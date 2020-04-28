<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Supsign\ContaoConnectorsBundle\Entity\FtpData;
use Supsign\ContaoConnectorsBundle\Entity\FtpProtocols;

/**
 * @Route("/contao", defaults={
 *     "_scope" = "backend",
 *     "_token_check" = false,
 *     "_backend_module" = "connectors"
 * })
 */
class BackendController extends AbstractController
{

    /**
     * @Route("/ftp-connections", name="supsign.connectors")
     */

    public function default()
    {
        return new Response(
            $this->get('twig')->render('@ContaoConnectors/default.html.twig', [])
        );
    }

    /**
     * @Route("/ftp-connections/add", name="supsign.connectors.add")
     */

    public function add()
    {
        $ftp  = new \StdClass;
        $ftp->title = 'FTP';
        $sftp = new \StdClass;
        $sftp->title = 'SFTP';

        $data = ['ftpProtocols' => array($ftp, $sftp)];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/add.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/edit", name="supsign.connectors.edit")
     */

    public function edit()
    {

        // $test = FtpProtocols::findAll();

        var_dump(
            class_exists('FtpProtocols'),
            class_exists('FtpProtocolsModel')
        );


        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', [])
        );
    }
}
