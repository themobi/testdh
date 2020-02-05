<?php

namespace App\Domain\User;

interface UserFactory
{
    /**
     * @param NameOfUser $nameofuser
     * @param EmailAddress $email
     * @param Password $password
     *
     * @return mixed
     */
    public function build(UserId $userId, EmailAddress $email, Password $password);
}
