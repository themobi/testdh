<?php

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class RepositoryFactory
{
    /**
     * @return ObjectRepository|EntityRepository The repository class.
     */
    public static function get($entityManager, $entityName)
    {
        return $entityManager->getRepository($entityName);
    }
}
