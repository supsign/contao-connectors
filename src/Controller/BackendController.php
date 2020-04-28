<?php

namespace Supsign\ContaoConnectorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Contao\MemberModel;
use Contao\MemberGroupModel;

/**
 * @Route("/contao/test-route",
 *     name=BackendController::class,
 *     defaults={
 *         "_scope" = "backend",
 *         "_token_check" = true,
 *         "_backend_module" = "connectors-bundle"
 *     }
 * )
 */
class BackendController extends AbstractController
{
    private $twig;
    
    public function __construct(TwigEnvironment $twig)
    {
        $this->twig = $twig;
    }

    public function __invoke()
    {
        return new Response(
            $this->get('twig')->render('@ContaoConnectorsBundle/default.html.twig', [])
        );
    }

    /**
     * @Route("/connectors-bundle", name="supsign.test")
     */

    public function default()
    {
        return new Response(
            this->get('twig')->render('@ContaoConnectorsBundle/default.html.twig', [])
        );
    } 
}