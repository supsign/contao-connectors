<?php

namespace Supsign\ContaoConnectorsBundle\Model;

use Contao\Model;
// use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;
// use Supsign\ContaoConnectorsBundle\Model\FfpSyncConfigsModel;

/**
 * add properties for IDE support
 * 
 * @property string $hash
 */
class FtpDataModel extends Model
{
    protected static $strTable = 'tl_ftp_data';
    // protected $ftpProtocol;
    // protected $ftpSyncConfig;

    // if you have logic you need more often, you can implement it here
    public function setHash()
    {
        $this->hash = md5($this->id);
    }

    // public function __get($key) {
    //     $class = 'Supsign\ContaoConnectorsBundle\Model\\'.ucfirst($key).'sModel';

    // 	switch ($key) {
    // 		case 'ftpProtocol':
    //             $method  = 'findByPk';
    //             $idField = $key.'Id';
    //             break;

    // 		case 'ftpSyncConfig':
    //             $method = 'findByFtpDataId';
    //             $idField = 'id';
    //             break;
    		
    // 		default:
    // 			return parent::__get($key);
    // 	}

    //     $this->$key = $class::$method($this->$idField);

    //     return $this->$key;
    // }
}