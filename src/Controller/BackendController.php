<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Supsign\ContaoConnectorsBundle\Entity\FtpData;
use Supsign\ContaoConnectorsBundle\Entity\FtpProtocols;
use Supsign\ContaoConnectorsBundle\Repository\ConnectorsRepository AS PleaseWork;

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
        $ftp  = array('title' => 'FTP');
        $sftp = array('title' => 'SFTP');

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

        $fuckthis = new PleaseWork;


        // $test = ConnectorsRepository::findAll();

        var_dump(
            $fuckthis,
            $fuckthis::findAll()
        );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', [])
        );
    }
}
