<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\EntityManagerTrait;

class FtpConnection {
	use EntityManagerTrait;

	protected 
		$connection = null,
		$dateFormat = 'D.m.Y H:i:s',
		$file = null,
		$files = null,
		$ftpConnections = [],
		$localDirectory = null,
		$localFile = null,
		$login = null,
		$remoteDirectory = null,
		$remoteFile = null,
		$password = null,
		$port = null,
		$protocol = null,
		$server = null,
		$syncConfigs = null,
		$user = null;

	public function __construct() {
		$this->ftpConnections = $this->getRepository('FtpData')->findAll();
	}

	protected function connect() {
		switch ($this->protocol) {
			case 'FTP':
				$this->connection = ftp_connect($this->server, $this->port);
				break;
			
			case 'SFTP':
			default:
				$this->connection = ssh2_connect($this->server, $this->port);
				break;
		}

        if (!$this->connection)
            throw new \Exception('Could not connect to "'.$this->server.'" on port "'.$this->port.'".');

		return $this;
	}

	protected function disconnect() {

	}

	protected function downloadFile($localFile, $remoteFile) {
		switch ($this->protocol) {
			case 'FTP':
				# code...
				break;
						
			case 'SFTP':
			default:
				# code...
				break;
		}
	}

	protected function getFiles() {
		return array_keys(
			array_merge(
				array_flip($this->readLocalDirectory()),
				array_flip($this->readRemoteDirectory())
			)
		);	
	}

	protected function getFilePath($source) {
		switch ($source) {
			case 'local': return $this->localFile;
			case 'remote': return $this->remoteFile;
			default: throw new \Exception('invalid file source');
		}
	}

	protected function getFileHash($source) {
		return hash_file('md5', $this->getFilePath($source)) ;
	}

	protected function getFileTime($source, $format = null) {
		$filetime = filemtime($this->getFilePath($source));

		if ($format AND $filetime)
			return (new \DateTime())->setTimestamp($filetime)->format($format);

		return $filetime;
	}

	protected function getLocalFileHash(){
		return $this->getFileHash('local');
	}

	protected function getLocalFileTime($format = null) {
		return $this->getFileTime('local', $format);
	}

	protected function getRemoteFileHash(){
		return $this->getFileHash('remote');
	}

	protected function getRemoteFileTime($format = null) {
		return $this->getFileTime('remote', $format);
	}

	protected function fileExists($source) {
		return file_exists($this->getFilePath($source));
	}

	protected function fileExistsLocal() {
		return $this->fileExists('local');
	}

	protected function fileExistsRemote() {
		return $this->fileExists('remote');
	}

	protected function login() {
		if (!$this->connection)
			$this->connect();

		switch ($this->protocol) {
			case 'FTP':
				# code...
				break;
						
			case 'SFTP':
			default:
				if (!ssh2_auth_password($this->connection, $this->user, $this->password) )	//	SSH key variant? 
					throw new \Exception('Could not authenticate with username '.$username.' and password '.$password);

		        $this->login = ssh2_sftp($this->connection);

		        if (!$this->login)
		            throw new \Exception('Could not initialize SFTP subsystem.');

				break;
		}

		return $this;
	}

	protected function uploadFile($localFile, $remoteFile) {	//	deprecated
		switch ($this->protocol) {
			case 'FTP':
				# code...
				break;
						
			case 'SFTP':
			default:
			    $resFile = fopen('ssh2.sftp://'.$this->login.'/'.$remoteFile, 'w');	//	deprecated
			    fwrite($resFile, file_get_contents());
			    fclose($resFile);

				break;
		}

        return $this;
	}

	protected function readLocalDirectory() {
		return self::scanDir($this->localDirectory);
	}

	protected function readFile($source) {
		return file_get_contents($this->getFilePath($source));
	}

	protected function readLocalFile() {
		return $this->readFile('local');
	}

	protected function readRemoteDirectory() {
		return self::scanDir($this->remoteDirectory);
	}

	protected function readRemoteFile() {
		return $this->readFile('remote');
	}

	protected function setConnection($title) {
		foreach ($this->ftpConnections AS $connection) {
			if ($connection->getTitle() == $title) {
				$this->protocol 	= $connection->getProtocol()->getTitle();
				$this->server 		= $connection->getServer();
				$this->port   		= $connection->getPort();
				$this->password 	= $connection->getPassword();
				$this->user 		= $connection->getUser();
				$this->syncConfigs  = $connection->getSyncConfigs();
			}
		}

		return $this->connect();
	}

	protected function setLocalDirectory($dir) {
		$this->localDirectory = $dir;

		return $this;
	}

	protected function setRemoteDirectory($dir) {
		switch ($this->protocol) {
			case 'SFTP':
				$this->remoteDirectory = 'ssh2.sftp://'.$this->login.$dir;
				break;
			
			default:
				$this->remoteDirectory = $dir;
				break;
		}

		return $this;
	}

	protected static function scanDir($dir) {
		foreach ($filenames = scandir($dir) AS $key => $filename)
			if ($filename{0} == '.')
				unset($filenames[$key]);

		return array_values($filenames);
	}

	protected function syncDirectory() {
		return $this->syncFiles();
	}

	protected function syncConnections() {
		foreach ($this->ftpConnections AS $connection) {
			$this->protocol 	= $connection->getProtocol()->getTitle();
			$this->server 		= $connection->getServer();
			$this->port   		= $connection->getPort();
			$this->password 	= $connection->getPassword();
			$this->user 		= $connection->getUser();
			$this->syncConfigs  = $connection->getSyncConfigs();

			$this->login();

			foreach ($this->syncConfigs AS $syncConfig) {
				$this->setLocalDirectory($syncConfig->getSourcePath());
				$this->setRemoteDirectory($syncConfig->getDestinationPath()); 

				$this->syncDirectory();
			}
		}

		return $this;
	} 

	protected function syncFile() {
		var_dump($this->file);

		if ($this->getLocalFileTime() == $this->getRemoteFileTime())
			$newer = '';
		else
			$newer = $this->getLocalFileTime() < $this->getRemoteFileTime() ? 'remote' : 'local';

		var_dump(
			[
				'existsLocal' => $this->fileExistsLocal(),
				'existsRemote' => $this->fileExistsRemote(),
				'localTime' => $this->getLocalFileTime($this->dateFormat),
				'remoteTime' => $this->getRemoteFileTime($this->dateFormat),
				'indentical' => [
					array('hash' => $this->getLocalFileHash() == $this->getRemoteFileHash()),
					array('time' => $this->getRemoteFileTime() == $this->getLocalFileTime()),
				],
				'newer' => $newer
			]
		);

		echo '<hr>';
	}

	protected function syncFiles() {
		foreach ($this->getFiles() AS $file) {
			$this->file = $file;
			$this->localFile = $this->localDirectory.$file;
			$this->remoteFile = $this->remoteDirectory.$file;

			$this->syncFile();
		}

		return $this;
	}

	public function test() {
		$this->syncConnections();

		return $this;
	}

}
















