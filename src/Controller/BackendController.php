<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Contao\MemberModel;
use Contao\MemberGroupModel;

/**
 * @Route("/contao", defaults={
 *     "_scope" = "backend",
 *     "_token_check" = false,
 *     "_backend_module" = "connectors-bundle"
 * })
 */
class BackendController extends AbstractController
{

    /**
     * @Route("/ftpconnector", name="supsign.ftpConnections")
     */

    public function __invoke()
    {
        $data = [];

        return new Response(
            $this->get('twig')->render('default.html.twig', $data)
        );
    }
}
