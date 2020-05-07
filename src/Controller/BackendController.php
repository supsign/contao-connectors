<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Supsign\ContaoConnectorsBundle\Entity\FtpData;
use Supsign\ContaoConnectorsBundle\Entity\FtpProtocols;
use Supsign\ContaoConnectorsBundle\Entity\FtpSyncConfigs;

/**
 * @Route("/contao", defaults={
 *     "_scope" = "backend",
 *     "_token_check" = false,
 *     "_backend_module" = "connectors"
 * })
 */
class BackendController extends AbstractController
{
    protected $entityNamespace = 'Supsign\ContaoConnectorsBundle\Entity\\';

    /**
     * @Route("/ftp-connections/config/delete", name="supsign.connectors.config.delete")
     */

    public function deleteConfig()
    {
        if (!empty($_GET['id']) ) {
            $entry = $this->getRepository('FtpSyncConfigs')->find($_GET['id']);

            if ($entry) {
                $this->getEntityManager()->remove($entry);
                $this->getEntityManager()->flush();
            }
        }

        $data = ['ftpData' => $this->getRepository('FtpData')->findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/delete", name="supsign.connectors.delete")
     */

    public function deleteConnection()
    {
        if (!empty($_GET['id']) ) {
            $entry = $this->getRepository('FtpData')->find($_GET['id']);

            if ($entry) {
                $this->getEntityManager()->remove($entry);
                $this->getEntityManager()->flush();
            }
        }

        $data = ['ftpData' => $this->getRepository('FtpData')->findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/config/edit", name="supsign.connectors.config.edit")
     */

    public function editConfig()
    {
        if (empty($_GET['id']) ) {
            $entry = new FtpSyncConfigs;
            $ftpConnection_id = $_GET['parent_id'];
        } else {
            $entry = $this->getRepository('FtpSyncConfigs')->find($_GET['id']);
            $ftpConnection_id = $entry->getFtpConnection()->getId();
        }


        $data = array(
            'config' => $entry,
            'ftpConnection_id' => $ftpConnection_id
        );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/editConnectionConfig.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/edit", name="supsign.connectors.edit")
     */

    public function editConnection()
    {
        $data = array(
            'ftpProtocols' => $this->getRepository('FtpProtocols')->findAll(),
            'ftpEntry' => !empty($_GET['id']) ? $this->getRepository('FtpData')->find($_GET['id']) : new FtpData
        );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/editConnection.html.twig', $data)
        );
    }

    protected function getEntityManager() {
        if (!$this->entityManager)
            $this->entityManager = \Contao\System::getContainer()->get('doctrine.orm.default_entity_manager');

        return $this->entityManager;
    }

    protected function getRepository($entity) {
        return $this->getEntityManager()->getRepository($this->entityNamespace.$entity);
    }

    /**
     * @Route("/ftp-connections", name="supsign.connectors")
     */

    public function listConnections()
    {
        $data = array(
            'ftpData' => $this->getRepository('FtpData')->findAll()
        );

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/save", name="supsign.connectors.save")
     */

    /**
     * @Route("/ftp-connections/config/save", name="supsign.connectors.config.save")
     */

    public function saveConfig()
    {
        if (!empty($_GET['id']) )
            $entry = $this->getRepository('FtpSyncConfigs')->find($_GET['id']);
        else
            $entry = new FtpSyncConfigs;

        foreach ($_POST AS $key => $value) {
            if (empty($value) )
                throw new \Exception(__FILE__.':'.__LINE__.' - no value for "'.$key.'"', 1);

            switch ($key) {
                case 'ftpConnection':
                    $value = $this->getRepository('FtpData')->find($value);

                default:
                    $entry->{'set'.ucfirst($key)}($value);
                    break;
            }
        }

        $entry->setTstamp(time() );

        $this->getEntityManager()->persist($entry);
        $this->getEntityManager()->flush();

        $data = ['ftpData' => $this->getRepository('FtpData')->findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    public function saveConnection()
    {
        if (!empty($_GET['id']) )
            $entry = $this->getRepository('FtpData')->find($_GET['id']);
        else
            $entry = new FtpData;

        // var_dump($_POST);

        foreach ($_POST AS $key => $value) {
            if (empty($value) )
                throw new \Exception(__FILE__.':'.__LINE__.' - no value for "'.$key.'"', 1);

            switch ($key) {
                case 'protocol':
                    $value = $this->getRepository('FtpProtocols')->find($value);

                default:
                    $entry->{'set'.ucfirst($key)}($value);
                    break;
            }
        }

        $entry->setTstamp(time() );

        $this->getEntityManager()->persist($entry);
        $this->getEntityManager()->flush();

        $data = ['ftpData' => $this->getRepository('FtpData')->findAll()];

        return new Response(
            $this->get('twig')->render('@ContaoConnectors/index.html.twig', $data)
        );
    }

    /**
     * @Route("/ftp-connections/test", name="supsign.connectors.test")
     */

    public function test()
    {

        $ftpData = $this->getEntityManager()->getRepository($this->entityNamespace.'FtpData')->findAll();

        var_dump($ftpData);


        return new Response(
            $this->get('twig')->render('@ContaoConnectors/test.html.twig', [])
        );
    }    
}
