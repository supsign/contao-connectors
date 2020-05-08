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

		return $this->login();
	}

	public function disconnect() {

	}

	public function login() {
		if (!ssh2_auth_password($this->connection, $this->user, $this->password) )	//	SSH key variant? 
			throw new \Exception('Could not authenticate with username '.$username.' and password '.$password);

        $this->sftp = ssh2_sftp($this->connection);

        if (!$this->sftp)
            throw new \Exception('Could not initialize SFTP subsystem.');

		return $this;
	}

	public function uploadFile($localFile, $remoteFile) {
		$stream = fopen('ssh2.sftp://'.$this->sftp.$remote_file, 'w');

        if (! $stream)
            throw new \Exception('Could not open file: '.$remoteFile);

        $fileContent = file_get_contents($localFile);

        if (fwrite($stream, $fileContent) === false)
            throw new \Exception('Could not send data from file: '. $localFile);

        fclose($stream);

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

}