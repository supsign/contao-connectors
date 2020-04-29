<?php

namespace Supsign\ContaoConnectorsBundle\Model;

use Contao\Model;
use Supsign\ContaoConnectorsBundle\Entity\FtpProtocols;

/**
 * add properties for IDE support
 * 
 * @property string $hash
 */
class FtpProtocolsModel extends Model
{
    protected static $strTable = 'tl_ftp_protocls';

    // if you have logic you need more often, you can implement it here
    public function setHash()
    {
        $this->hash = md5($this->id);
    }
}