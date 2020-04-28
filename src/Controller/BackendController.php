<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contao", defaults={
 *     "_scope" = "backend",
 *     "_token_check" = false,
 *     "_backend_module" = "contao-connectors"
 * })
 */
class BackendController extends AbstractController
{

    /**
     * @Route("/connectors", name="supsign.test")
     */

    public function default()
    {
        return new Response(
            $this->get('twig')->render('@ContaoConnectorsBundle/default.html.twig', [])
        );
    }
}