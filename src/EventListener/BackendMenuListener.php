<?php

namespace Supsign\ContaoConnectorsBundle\EventListener;

use Contao\CoreBundle\Event\MenuEvent;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class BackendMenuListener
{
    protected $router;
    protected $requestStack;

    public function __construct(RouterInterface $router, RequestStack $requestStack)
    {
        $this->router = $router;
        $this->requestStack = $requestStack;
    }

    public function onBuild(MenuEvent $event): void
    {
        $factory = $event->getFactory();
        $tree = $event->getTree();

        if ($tree->getName() !== 'mainMenu')
            return;

        if (!$tree->getChild('supsign') ) {
	        $node = $factory
	            ->createItem('supsign')
		            ->setUri('/')
		            ->setLabel('MSC.supisgn')
		            ->setLinkAttribute('class', 'group-system')
		            ->setLinkAttribute('onclick', "return AjaxRequest.toggleNavigation(this, 'supsign', '/')")
		            ->setChildrenAttribute('id', 'supsign')
		            ->setExtra('translation_domain', 'contao_default');

	        $contentNode = $tree->addChild($node);
    	}

        $menuItem = $factory
            ->createItem('connectors')
	            ->setUri($this->router->generate('supsign.Connectors') )
	            ->setLabel('MSC.ConnectorsName')
	            ->setLinkAttribute('title', 'MSC.ConnectorsTitle')														//	translation geht hier wohl nicht?
	            ->setCurrent($this->requestStack->getCurrentRequest()->get('_backend_module') === 'connectors')
	            ->setExtra('translation_domain', 'contao_default');

        $contentNode->addChild($menuItem);
    }
}
