<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/Connectors", name="supsign.Connectors")
     */

    public function default()
    {
        return new Response(
            $this->get('twig')->render('@ContaoConnectors/default.html.twig', [])
        );
    }


    /**
     * @Route("/Connectors/new", name="supsign.Connectors.archive")
     */

    public function archive()
    {
        return new Response(
            $this->get('twig')->render('@ContaoConnectors/archive.html.twig', [])
        );
    }


}
