<?php

namespace App\Infrastructure\Persistence\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;

class EntityManagerFactory
{
    /**
     * @return EntityManager
     */
    public static function build($conn)
    {
        \Doctrine\DBAL\Types\Type::addType('UserId', 'App\Infrastructure\Domain\User\DoctrineUserId');

        return EntityManager::create(
            $conn,
            Setup::createYAMLMetadataConfiguration([__DIR__ . '/Mapping'], true)
        );
    }
}
