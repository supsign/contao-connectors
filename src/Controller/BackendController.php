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
        return new Response(
            $this->get('twig')->render('@ContaoConnectors/add.html.twig', [])
        );
    }

    /**
     * @Route("/ftp-connections/edit", name="supsign.connectors.edit")
     */

    public function edit()
    {

        $test = FtpProtocols::findAll();

        var_dump($test);


        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', [])
        );
    }
}
