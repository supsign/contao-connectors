<?php

namespace Supsign\ContaoConnectorsBundle\Repository;

use Doctrine\ORM\EntityRepository;

class ConnectorsRepository extends EntityRepository
{
    public function findAll(array $orderBy = [])
    {
        return $this->findBy([], $orderBy);
    }
}