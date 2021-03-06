<?php

namespace Supsign\ContaoConnectorsBundle\Entity;
use \Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Log
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_ftp_sync_configs")
 * @ORM\Entity(repositoryClass="Supsign\ContaoConnectorsBundle\Repository\ConnectorsRepository")
 */
class FtpSyncConfigs
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var int
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    protected $tstamp;

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""})
     */
    protected $title;

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""}, nullable=true)
     */
    protected $localPath;

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""}, nullable=true)
     */
    protected $remotePath;

    /**
     * @ORM\ManyToOne(targetEntity="FtpData", inversedBy="syncConfigs")
     */
    protected $ftpConnection;

    // Diese Funktion ist sehr hilfreich, um alle Daten als Array zu erhalten. 
    public function getData() {
        $arrData = [];
        foreach(preg_grep('|^get(?!Data)|', get_class_methods($this)) as $method) {
            $arrData[($Field = lcfirst(substr($method, 3)))] = $this->{$method}();
            if(is_object($arrData[$Field])) {
                $arrData[$Field] = $arrData[$Field]->getData();
            }
        }
        
        return $arrData;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of tstamp
     *
     * @return  int
     */ 
    public function getTstamp()
    {
        return $this->tstamp;
    }

    /**
     * Set the value of tstamp
     *
     * @param  int  $tstamp
     *
     * @return  self
     */ 
    public function setTstamp(int $tstamp)
    {
        $this->tstamp = $tstamp;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param  string  $title
     *
     * @return  self
     */ 
    public function setTitle(string $title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of localPath
     *
     * @return  string
     */ 
    public function getLocalPath()
    {
        return $this->addTrailingSlashToPaths($this->localPath);
    }

    /**
     * Set the value of localPath
     *
     * @param  string  $localPath
     *
     * @return  self
     */ 
    public function setLocalPath(string $localPath)
    {
        $this->localPath = $localPath;

        return $this;
    }

    /**
     * Alias of getLocalPath
     */ 
    public function getSourcePath()
    {
        return $this->getlocalPath();
    }

    /**
     * Alias of setLocalPath
     */ 
    public function setSourcePath(string $sourcePath)
    {
        return $this->setlocalPath($sourcePath);
    }

    /**
     * Get the value of remotePath
     *
     * @return  string
     */ 
    public function getRemotePath()
    {
        return $this->addTrailingSlashToPaths($this->remotePath);
    }

    /**
     * Set the value of remotePath
     *
     * @param  string  $remotePath
     *
     * @return  self
     */ 
    public function setRemotePath(string $remotePath)
    {
        $this->remotePath = $remotePath;

        return $this;
    }

    /**
     * Alias of getRemotePath
     */ 
    public function getDestinationPath()
    {
        return $this->getRemotePath();
    }

    /**
     * Alias of setRemotePath
     */ 
    public function setDestinationPath(string $destinationPath)
    {
        return $this->setRemotePath($destinationPath);
    }

    /**
     * Get the value of ftpConnection
     *
     * @return  FtpData
     */ 
    public function getFtpConnection()
    {
        return $this->ftpConnection;
    }

    /**
     * Set the value of ftpConnection
     *
     * @param  FtpData $ftpConnection
     *
     * @return  self
     */ 
    public function setFtpConnection(FtpData $ftpConnection)
    {
        $this->ftpConnection = $ftpConnection;

        return $this;
    }

    protected function addTrailingSlashToPaths($string) {
        if (substr($string, -1) != '/')
            return $string.'/';

        return $string;
    }
}