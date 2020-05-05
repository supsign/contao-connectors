<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\ORM\EntityManager;
use Supsign\ContaoConnectorsBundle\Model\FtpDataModel;
use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;
use Supsign\ContaoConnectorsBundle\FtpConnection;

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
     * @Route("/ftp-connections/delete", name="supsign.connectors.delete")
     */

    public function delete()
    {
        if (!empty($_GET['id']) )
            FtpDataModel::findByPk($_GET['id'])->delete();

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
        if (!empty($_GET['id']) )
            $entry = FtpDataModel::findByPk($_GET['id']);
        else
            $entry = new FtpDataModel;

        // var_dump($_POST);

        foreach ($_POST AS $key => $value) {
            if (empty($value) )
                throw new \Exception(__FILE__.':'.__LINE__.' - no value for "'.$key.'"', 1);

            switch ($key) {
                //  data validation

                default:
                    $entry->{$key} = $value;
                    break;
            }
        }

        $entry->tstamp = time();

        $entry->save();

        $data = ['ftpData' => FtpDataModel::findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/test", name="supsign.connectors.test")
     */

    public function test()
    {
        var_dump(
            new FtpConnection
        );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/test.html.twig', [])
        );
    }    
}
