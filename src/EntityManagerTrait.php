<?php

namespace Supsign\ContaoConnectorsBundle;


trait EntityManagerTrait {
    protected $entityNamespace = 'Supsign\ContaoConnectorsBundle\Entity\\';
    protected $entityManager = null;

    protected function getEntityManager() {
        if (!$this->entityManager)
            $this->entityManager = \Contao\System::getContainer()->get('doctrine.orm.default_entity_manager');

        return $this->entityManager;
    }

    protected function getRepository($entity) {
        return $this->getEntityManager()->getRepository($this->entityNamespace.$entity);
    }
}