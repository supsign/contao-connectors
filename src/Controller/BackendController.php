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

    public function default()
    {
        $data = ['ftpData' => FtpDataModel::findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/edit", name="supsign.connectors.edit")
     */

    public function edit()
    {
        $entry = !empty($_GET['id']) ? FtpDataModel::findByPk($_GET['id']) : new FtpDataModel;

        $data = array(
            'ftpProtocols' => FtpProtocolsModel::findAll(),
            'ftpEntry' => $entry
        );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/edit.html.twig', $data)
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

        var_dump($_POST);

        foreach ($_POST AS $key => $value) {



        }


        $entry->ftpProtocolId = $_POST['ftpProtocolId'];
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
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }
}
