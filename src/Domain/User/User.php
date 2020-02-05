<?php

namespace App\Domain\User;

use App\Domain\Aggregate;

class User extends Aggregate
{
    /**
     * @var UserId
     */
    private $userId;

    /**
     * @var NameOfUser
     */
    protected $name;

    /**
     * @var EmailAddress
     */
    protected $email;

    /**
     * @var Password
     */
    protected $password;

    /**
     * @var \DateTime
     */
    protected $created_at;

    /**
     * @param NameOfUser $name
     * @param EmailAddress $email
     * @param Password $password
     */
    private function __construct(NameOfUser $name, EmailAddress $email, Password $password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->created_at = new \DateTime();

        $this->recordThat(
            new UserRegistered(
                $this->name,
                $this->email
            )
        );
    }

    public static function draft(string $name, string $email, string $password): User
    {
        return new self(
            NameOfUser::fromValue($name),
            EmailAddress::fromValue($email),
            Password::fromValue($password)
        );
    }

    public static function fromState(array $state): User
    {
        return new self(
            NameOfUser::fromValue($state['name']),
            EmailAddress::fromValue($state['email']),
            Password::fromValue($state['password']),
            $state['created_at']
        );
    }

    /**
     * @return NameOfUser
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }
}
