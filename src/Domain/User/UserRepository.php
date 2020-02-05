<?php

namespace App\Domain\User;

/**
 * Interface UserRepository.
 */
interface UserRepository
{
    /**
     * @param UserId $userId
     *
     * @return User
     */
    public function ofId(UserId $userId);

    /**
     * @param EmailAddress $email
     *
     * @return User
     */
    public function ofEmail(EmailAddress $email);

    /**
     * @param User $user
     */
    public function add(User $user);
}
