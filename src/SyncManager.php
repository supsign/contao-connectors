<?php

namespace Supsign\ContaoConnectorsBundle;

use Supsign\ContaoConnectorsBundle\EntityManagerTrait;

class SyncManager extends FtpConnection {
	protected $direction = null;

	protected static function explodeFilePath($file) {
		return explode('/', $file);
	}

	protected static function getFolder($file) {
		$path = self::explodeFilePath($file);

		array_pop($path);

		return implode('/', $path).'/';
	}

	protected static function getFilename($file) {
		$path = self::explodeFilePath($file);
		
		return array_pop($path);
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

	public function syncDown() {
		$this->direction = 'down';

		return $this->syncConnections();
	}

	public function syncUp() {
		$this->direction = 'up';

		return $this->syncConnections();
	}

	protected function syncFile() {
		switch ($this->direction) {
			case 'down':
				switch (true) {
					case !$this->fileExistsLocal() AND $this->fileExistsRemote():
					case $this->getLocalFileTime() < $this->getRemoteFileTime():
						$this->downloadFile();
						break;

					case $this->fileExistsLocal() AND !$this->fileExistsRemote():
						$this->deleteLocalFile();

						$dir = self::getFolder($this->file);
						$dirContents = self::readDirectory($dir);
						break;

					default:
						break;
				}
				break;
			
			case 'up':
				switch (true) {
					case $this->fileExistsLocal() AND !$this->fileExistsRemote():
					case $this->getLocalFileTime() > $this->getRemoteFileTime():
						$this->uploadFile();
						break;

					case !$this->fileExistsLocal() AND $this->fileExistsRemote():
						$this->deleteLocalFile();

						$dir = self::getFolder($this->file);
						$dirContents = self::readDirectory($dir);
						break;

					default:
						break;
				}
				break;
		}

		return $this;
	}

	protected function syncFiles() {
		foreach ($this->getFiles() AS $file) {
			$subfolders = explode('/', $file);
			array_pop($subfolders);

			$localPath = $this->localDirectory;
			$remotePath = $this->remoteDirectory;

			foreach ($subfolders AS $folder) {
				$localPath .= $folder.'/';
				$remotePath .= $folder.'/';

				if ($this->direction == 'down' AND !is_dir($localPath))
					mkdir($localPath);

				if ($this->direction == 'up' AND !is_dir($remotePath))
					mkdir($remotePath);
			}

			$this->file = $file;
			$this->localFile = $this->localDirectory.$file;
			$this->remoteFile = $this->remoteDirectory.$file;

			$this->syncFile();
		}

		return $this;
	}
}