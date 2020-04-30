<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Supsign\ContaoConnectorsBundle\Model\FtpDataModel;
use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;
Supsign\ContaoConnectorsBundle\Entity\FtpData;

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
        $data = ['ftpProtocols' => FtpProtocolsModel::findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', [])
        );
    }

    /**
     * @Route("/ftp-connections/list", name="supsign.connectors.list")
     */

    public function list()
    {

        $data = ['ftpData' => FtpDataModel::findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/list.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/target", name="supsign.connectors.target")
     */

    public function target()
    {
        $entry = new FtpData();

        var_dump($entry);

        // $entry->setName($_POST['name']);

        $enty->name = $_POST['name'];
        $enty->description = $_POST['description'];
        $enty->server = $_POST['server'];
        $enty->port = $_POST['port'];
        $enty->user = $_POST['user'];
        $enty->password = $_POST['password'];

        var_dump($entry);

        $entry->save();

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', [])
        );
    }
}
