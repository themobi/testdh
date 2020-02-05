<?php

namespace App\Application\Service\User;

class SignupRequest
{
    private $name;
    private $email;
    private $password;

    public function __construct($name, $email, $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function password()
    {
        return $this->password;
    }
}
