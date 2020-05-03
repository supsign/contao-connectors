<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Supsign\ContaoConnectorsBundle\Model\FtpDataModel;
use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;
use Supsign\ContaoConnectorsBundle\Entity\FtpData;
use \Doctrine\ORM\EntityManager;

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

    public function
    default()
    {
        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', [])
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
        $data = array(
            'ftpProtocols' => FtpProtocolsModel::findAll(),
            'ftpEntry' => FtpDataModel::findByPk($_GET['id'])
        );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', $data)
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
     * @Route("/ftp-connections/save", name="supsign.connectors.save")
     */

    public function save()
    {
        if (!empty($_GET['id']))
            $entry = FtpDataModel::findByPk($_GET['id']);
        else
            $entry = new FtpDataModel;

        $entry->ftpProtocolId = $_POST['protocol_id'];
        $entry->title = $_POST['title'];
        $entry->description = $_POST['description'];
        $entry->server = $_POST['server'];
        $entry->port = $_POST['port'];
        $entry->user = $_POST['user'];
        $entry->password = $_POST['password'];
        $entry->tstamp = time();

        $entry->save();

        $data = ['ftpData' => FtpDataModel::findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/list.html.twig', $data)
        );
    }
}
