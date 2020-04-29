<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Supsign\ContaoConnectorsBundle\Model\FtpDataModel;
use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;

use Supsign\ContaoConnectorsBundle\TestClass;

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

        $data = ['ftpProtocols' => FtpProtocolsModel::findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/add.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/edit", name="supsign.connectors.edit")
     */

    public function edit()
    {

        $ftpProtocols = FtpProtocolsModel::findAll();

        foreach ($ftpProtocols AS $ftpProtocol)
            var_dump(
                $ftpProtocol,
                $ftpProtocol->title
            );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', [])
        );
    }

    /**
     * @Route("/ftp-connections/target", name="supsign.connectors.target")
     */

    public function target()
    {

        var_dump('target');

        $ftpProtocols = FtpProtocolsModel::findAll();

        foreach ($ftpProtocols AS $ftpProtocol)
            var_dump(
                $ftpProtocol,
                $ftpProtocol->title
            );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', [])
        );
    }
}
