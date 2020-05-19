<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\EntityManagerTrait;

class FtpConnection {
	use EntityManagerTrait;

	private 
		$connection = null,
		$ftpConnections = [],
		$password = null,
		$port = null,
		$protocol = null,
		$server = null,
		$sftp = null,
		$user = null;

	public function __construct() {
		$this->ftpConnections = $this->getRepository('FtpData')->findAll();
	}

	public function connect() {
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

		return $this->login();
	}

	public function disconnect() {

	}

	public function login() {
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

	public function uploadFile($localFile, $remoteFile) {
		switch ($this->protocol) {
			case 'FTP':
				# code...
				break;
						
			case 'SFTP':
			default:
				$csv_filename = 'home/test.csv';

			    $resFile = fopen("ssh2.sftp://{$this->sftp}/".$csv_filename, 'w');
			    fwrite($resFile, 'Testing');
			    fclose($resFile);  

				break;
		}

        return $this;
	}

	public function iterate() {
		foreach ($this->ftpConnections AS $connection) {
			$this->protocol = $connection->getProtocol()->getTitle();
			$this->server 	= $connection->getServer();
			$this->port   	= $connection->getPort();
			$this->password = $connection->getPassword();
			$this->user 	= $connection->getUser();

			$this->connect();
		}
		
		return $this;
	}

	public function setConnection($title) {
		foreach ($this->ftpConnections AS $connection) {
			if ($connection->getTitle() == $title) {
				$this->protocol = $connection->getProtocol()->getTitle();
				$this->server 	= $connection->getServer();
				$this->port   	= $connection->getPort();
				$this->password = $connection->getPassword();
				$this->user 	= $connection->getUser();
			}
		}



	}

	public function test() {
		$this->setConnection('test verbindung');
		$this->connect();

		$source = '/Applications/MAMP/htdocs/autosync.supsign.dev/files/swiss-vr.sql.zip';
		$destination = 'home/swiss-vr.sql.zip';

		$this->uploadFile($source, $destination);


	}

}