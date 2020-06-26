<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\EntityManagerTrait;

class SyncManager extends FtpConnection {

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
		switch (true) {
			case !$this->fileExistsLocal() AND $this->fileExistsRemote():
			case $this->getLocalFileTime() < $this->getRemoteFileTime():
				$this->downloadFile();
				break;

			case $this->fileExistsLocal() AND !$this->fileExistsRemote():
				$this->deleteLocalFile();
				break;

			default:
				break;
		}

		return $this;
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