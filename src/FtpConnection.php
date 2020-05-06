<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\Model\FtpDataModel;
use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;

class FtpConnection {
	private 
		$ftpConnections = [],
		$protocol = null,
		$server = null,
		$port = null,
		$password = null;

	public function __construct() {
		$this->ftpConnections = FtpDataModel::findAll();
	}

	public function connect() {

	}

	public function disconnect() {

	}

	public function moveFile() {

	}

	public function iterate() {
		foreach ($this->ftpConnections AS $connection) {
			$this->server 	= $connection->server;
			$this->port   	= $connection->port;
			$this->password = $connection->password;

			var_dump(
				$connection->server,
				$connection->port,
				$connection->password
			);
		}
		
	}

}