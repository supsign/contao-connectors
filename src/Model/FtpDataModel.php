<?php

namespace App\Model;

use Contao\Model;

/**
 * add properties for IDE support
 * 
 * @property string $hash
 */
class FtpDataModel extends Model
{
    protected static $strTable = 'tl_ftp_data';

    // if you have logic you need more often, you can implement it here
    public function setHash()
    {
        $this->hash = md5($this->id);
    }
}