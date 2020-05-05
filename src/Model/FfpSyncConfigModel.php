<?php

namespace Supsign\ContaoConnectorsBundle\Model;

use Contao\Model;
use Supsign\ContaoConnectorsBundle\Entity\FtpData;

/**
 * add properties for IDE support
 * 
 * @property string $hash
 */
class FfpSyncConfigModel extends Model
{
    protected static $strTable = 'tl_ftp_sync_config';

    // if you have logic you need more often, you can implement it here
    public function setHash()
    {
        $this->hash = md5($this->id);
    }
}