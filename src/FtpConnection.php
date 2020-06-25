<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\EntityManagerTrait;

class FtpConnection {
	use EntityManagerTrait;

	private 
		$connection = null,
		$ftpConnections = [],
		$localFolder = null,
		$remoteFolder = null,
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

	protected function readLocalDirectory() {




		return $this;
	}

	protected function readRemoteDirectory() {

		return $this;
	}

	protected function uploadFile($localFile, $remoteFile) {
		switch ($this->protocol) {
			case 'FTP':
				# code...
				break;
						
			case 'SFTP':
			default:
			    $resFile = fopen("ssh2.sftp://{$this->sftp}/".$remoteFile, 'w');
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

		return $this;
	}

	protected function syncConnection() {
		$localDir = $this->readLocalDirectory();


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
				$this->localFolder = $syncConfig->getSourcePath();
				$this->remoteFolder = $syncConfig->getDestinationPath();

				$this->syncConnection();
			}
		}

		return $this;
	} 

}
















