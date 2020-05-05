<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\Model\FtpDataModel;
use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;

class FtpConnection {
	private $ftpConnections = [];

	function __construct() {
		$this->ftpConnections = FtpDataModel::findAll();
	}

	public function connect() {

	}

	public function disconnect() {

	}

	public function moveFile() {

	}


}