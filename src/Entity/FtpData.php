<?php

namespace Supsign\ContaoConnectorsBundle\Entity;
use \Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Log
 *
 * @ORM\Entity
 * @ORM\Table(name="tl_ftp_data")
 * @ORM\Entity(repositoryClass="Supsign\ContaoConnectorsBundle\Repository\ConnectorsRepository")
 */
class FtpData
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
     * @ORM\Column(type="string", options={"default" : ""})
     */
    protected $description;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $ftpProtocolId;

    /**
     * @ORM\OneToOne(targetEntity="FtpProtocols")
     * @ORM\JoinColumn(name="ftpProtocolId", referencedColumnName="id")
     */
    protected $ftpProtocol;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $ftpSyncConfigId;

    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="FfpSyncConfigs", mappedBy="ftpData")
     */
    protected $ftpSyncConfig;

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""})
     */
    protected $server;

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""})
     */
    protected $port; 

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""})
     */
    protected $user; 

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""})
     */
    protected $password;

    public function __construct() {
        $this->ftpProtocol = new ArrayCollection();
        $this->ftpSyncConfig = new ArrayCollection();
    }

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
    public function getId(): int
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
     * Get the value of description
     *
     * @return  string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param  string  $description
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  int
     */ 
    public function getFtpProtocolId(): int
    {
        return $this->ftpProtocolId;
    }

    /**
     * Set the value of ftpProtocolId
     *
     * @param  int  $ftpProtocolId
     *
     * @return  self
     */ 
    public function setFtpProtocolId(int $ftpProtocolId)
    {
        $this->ftpProtocolId = $ftpProtocolId;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Set the value of server
     *
     * @param  string  $server
     *
     * @return  self
     */ 
    public function setServer(string $server)
    {
        $this->server = $server;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the value of port
     *
     * @param  string  $port
     *
     * @return  self
     */ 
    public function setPort(string $port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @param  string  $user
     *
     * @return  self
     */ 
    public function setUser(string $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of title
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }
}