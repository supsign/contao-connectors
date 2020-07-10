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
		            ->setLabel('Supsign')
		            ->setLinkAttribute('class', 'group-system')
		            ->setLinkAttribute('onclick', "return AjaxRequest.toggleNavigation(this, 'supsign', '/')")
		            ->setChildrenAttribute('id', 'supsign');

	        $contentNode = $tree->addChild($node);
    	} else {
            $contentNode = $tree->getChild('supsign');
        }

        $menuItem = $factory
            ->createItem('connectors')
	            ->setUri($this->router->generate('supsign.connectors') )
	            ->setLabel('FTP Verbindungen')
	            ->setLinkAttribute('title', 'FTP Verbindungen verwalten')
	            ->setCurrent($this->requestStack->getCurrentRequest()->get('_backend_module') === 'connectors');

        $contentNode->addChild($menuItem);
    }
}
