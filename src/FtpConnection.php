<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\EntityManagerTrait;

class FtpConnection {
	use EntityManagerTrait;

	private 
		$ftpConnections = [],
		$protocol = null,
		$server = null,
		$port = null,
		$password = null;

	public function __construct() {
		$this->ftpConnections = $this->getRepository('FtpData')->findAll();
	}

	public function connect() {

	}

	public function disconnect() {

	}

	public function moveFile() {

	}

	public function iterate() {
		foreach ($this->ftpConnections AS $connection) {
			$this->server 	= $connection->getServer();
			$this->port   	= $connection->getPort();
			$this->password = $connection->getPassword();

			var_dump(
				$this->server,
				$this->port,
				$this->password
			);
		}
		
	}

}