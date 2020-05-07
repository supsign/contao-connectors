<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use \Doctrine\ORM\EntityManager;
use Supsign\ContaoConnectorsBundle\Model\FtpDataModel;
use Supsign\ContaoConnectorsBundle\Model\FtpProtocolsModel;
use Supsign\ContaoConnectorsBundle\Model\FtpSyncConfigsModel;
use Supsign\ContaoConnectorsBundle\FtpConnection;

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
     * @Route("/ftp-connections/delete", name="supsign.connectors.delete")
     */

    public function deleteConnection()
    {
        if (!empty($_GET['id']) ) {
            $entry = FtpDataModel::findByPk($_GET['id']);

            if ($entry)
                $entry->delete();
        }

        $data = ['ftpData' => FtpDataModel::findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/edit", name="supsign.connectors.edit")
     */

    public function editConnection()
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

    public function getEntityManager() {
        if (!$this->entityManager)
            $this->entityManager = \Contao\System::getContainer()->get('doctrine.orm.default_entity_manager');

        return $this->entityManager;
    }

    /**
     * @Route("/ftp-connections", name="supsign.connectors")
     */

    public function listConnections()
    {
        $ftpData = FtpDataModel::findAll();

        foreach ($ftpData AS $ftpConnection) {
            var_dump(
                $ftpConnection->ftpProtocol,
                $ftpConnection->ftpSyncConfig
            );
        }

        $data = array(
            'ftpData' => $ftpData,
            'ftpProtocols' => FtpProtocolsModel::findAll()
        );

        // var_dump($ftpData);

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/save", name="supsign.connectors.save")
     */

    public function saveConnection()
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
        $entry = new FtpData;
        $entry
            ->setTitle('test title blubb')
            ->setDescription('Beschreibung')
            ->setTstamp(time() )
            ->setServer('hostname')
            ->setPort(3306)
            ->setUser('Benutzername')
            ->setPassword('1234xxx')
            ->setFtpProtocolId(2);

        // $entry = new FtpProtocols;
        // $entry
        //     ->setTitle('test title')
        //     ->setDescription('Beschreibung')
        //     ->setTstamp(time() );

        var_dump($entry);

        $this->getEntityManager()->persist($entry);
        $this->getEntityManager()->flush();

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/test.html.twig', [])
        );
    }    
}
