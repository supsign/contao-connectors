<?php

namespace Supsign\ContaoAutoSyncBundle\Repository;

use Doctrine\ORM\EntityRepository;

class AutoSyncRepository extends EntityRepository
{
    public function findAll(array $orderBy = [])
    {
        return $this->findBy([], $orderBy);
    }
}