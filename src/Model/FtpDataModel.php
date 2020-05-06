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
    protected $ftpProtocol;
    protected $ftpSyncConfig;

    // if you have logic you need more often, you can implement it here
    public function setHash()
    {
        $this->hash = md5($this->id);
    }

    public function __get($key) {
    	switch ($key) {
    		case 'ftpProtocol':
    		case 'ftpSyncConfig':

    			if (!property_exists($this, $key) )
    				throw new \Exception('property '.$key.' doesn\'t exist', 1);
    				
    			if (empty($this->$key) ) {
    				$id = $key.'Id';
    				$class = 'Supsign\ContaoConnectorsBundle\Model\\'.ucfirst($key).'sModel';

    				$this->$key = $class::findByPk($this->$id);
    			}

    			return $this->$key;
    		
    		default:
    			return parent::__get($key);
    	}
    }
}