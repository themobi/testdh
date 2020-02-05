<?php

namespace App\Infrastructure\Domain\User;

use App\Infrastructure\Domain\DoctrineEntityId;

class DoctrineUserId extends DoctrineEntityId
{
    public function getName()
    {
        return 'UserId';
    }

    protected function getNamespace()
    {
        return 'App\Domain\User';
    }
}
