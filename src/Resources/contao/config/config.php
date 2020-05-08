<?php

use Supsign\ContaoConnectorsBundle\Model\FtpDataModel;
use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;
use Supsign\ContaoConnectorsBundle\Model\FtpSyncConfigsModel;

$GLOBALS['TL_MODELS']['tl_ftp_data'] = FtpDataModel::class;
$GLOBALS['TL_MODELS']['tl_ftp_protocols'] = FtpProtocolsModel::class;
$GLOBALS['TL_MODELS']['tl_ftp_sync_configs'] = FtpSyncConfigsModel::class;


if (TL_MODE == 'BE') {
    $GLOBALS['TL_CSS'][] = '/bundles/contaoconnectors/css/supsign-connectors.css';
}
