<?php

namespace App\Infrastructure\Domain\User;

use App\Domain\User\User;
use App\Domain\User\UserId;
use Doctrine\ORM\EntityRepository;
use App\Domain\User\UserRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    /**
     * @param UserId $userId
     *
     * @return User
     */
    public function ofId(UserId $userId)
    {
        return $this->find($userId);
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function ofEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    /**
     * @param User $user
     */
    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }
}
