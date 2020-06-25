<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\EntityManagerTrait;

class FtpConnection {
	use EntityManagerTrait;

	private 
		$connection = null,
		$files = null,
		$ftpConnections = [],
		$localDirectory = null,
		$localFile = null,
		$remoteDirectory = null,
		$remoteFile = null,
		$password = null,
		$port = null,
		$protocol = null,
		$server = null,
		$sftp = null,
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

		// var_dump($this->server);

        if (!$this->connection)
            throw new \Exception('Could not connect to "'.$this->server.'" on port "'.$this->port.'".');

		return $this->login();
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
				array_flip($this->getLocalDirectory()),
				array_flip($this->getRemoteDirectory())
			)
		);	
	}

	protected function getLocalDirectory() {
		return self::scanDir($this->localDirectory);
	}

	protected function getRemoteDirectory() {
		return self::scanDir('ssh2.sftp://'.$this->sftp.'/'.$this->remoteDirectory);
	}

	protected function login() {
		switch ($this->protocol) {
			case 'FTP':
				# code...
				break;
						
			case 'SFTP':
			default:
				if (!ssh2_auth_password($this->connection, $this->user, $this->password) )	//	SSH key variant? 
					throw new \Exception('Could not authenticate with username '.$username.' and password '.$password);

		        $this->sftp = ssh2_sftp($this->connection);

		        if (!$this->sftp)
		            throw new \Exception('Could not initialize SFTP subsystem.');

				break;
		}

		return $this;
	}

	protected function uploadFile($localFile, $remoteFile) {
		switch ($this->protocol) {
			case 'FTP':
				# code...
				break;
						
			case 'SFTP':
			default:
			    $resFile = fopen('ssh2.sftp://'.$this->sftp.'/'.$remoteFile, 'w');
			    fwrite($resFile, file_get_contents($localFile));
			    fclose($resFile);  

				break;
		}

        return $this;
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

	public function test() {
		$this->syncConnections();

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

			$this->connect();

			foreach ($this->syncConfigs AS $syncConfig) {
				$this->localDirectory = $syncConfig->getSourcePath();
				$this->remoteDirectory = $syncConfig->getDestinationPath();

				$this->syncDirectory();
			}
		}

		return $this;
	} 

	protected function syncFiles() {
		foreach ($this->getFiles() AS $file) {
			var_dump($file);
		}

		return $this;
	}

}
















