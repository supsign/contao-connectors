<?php

namespace Supsign\ContaoConnectorsBundle\Entity;
use \Doctrine\ORM\Mapping as ORM;

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
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $ftpDataId;

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""})
     */
    protected $sourcePath;

    /**
     * @var string
     * @ORM\Column(type="string", options={"default" : ""})
     */
    protected $destinationPath;

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
}