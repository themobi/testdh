<?php

namespace App\Application\Transformer\User;

use Ddd\Application\DataTransformer\DataTransformer;

class UserTransformer implements DataTransformer
{
    private $user;
    
    /**
     * @codeCoverageIgnore
     * @return void
     */
    public function write($user)
    {
        $this->user = $user;

        return $this;
    }
    
    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function read()
    {
        return [
            'name' => $this->user->getName()->toValue(),
            'email' => $this->user->getEmail()->toValue()
        ];
    }
}
