<?php

namespace Supsign\ContaoConnectorsBundle\Model;

use Contao\Model;

/**
 * add properties for IDE support
 * 
 * @property string $hash
 */
class FtpSyncConfigsModel extends Model
{
    protected static $strTable = 'tl_ftp_sync_configs';

    // if you have logic you need more often, you can implement it here
    public function setHash()
    {
        $this->hash = md5($this->id);
    }
}