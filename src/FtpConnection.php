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
		$server = null;

	public function __construct() {
		$this->ftpConnections = $this->getRepository('FtpData')->findAll();
	}

	public function connect() {
		switch ($this->protocol) {
			case 'FTP':
				break;
			
			case 'SFTP':
			default:
				// $this->connection = ssh2_connect($this->server, $this->port);

				var_dump(
					$this->connection
				);
				break;
		}



	}

	public function disconnect() {

	}

	public function moveFile() {

	}

	public function iterate() {
		foreach ($this->ftpConnections AS $connection) {
			$this->protocol = $connection->getProtocol()->getTitle();
			$this->server 	= $connection->getServer();
			$this->port   	= $connection->getPort();
			$this->password = $connection->getPassword();

			$this->connect();
		}
		
	}

}