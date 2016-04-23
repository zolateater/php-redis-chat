<?php

namespace App\Exception\Application\Repository;

use App\Exception\Application\ApplicationException;

class LoginDoesNotExistsException extends ApplicationException
{
    /**
     * @var string
     */
    protected $login;
    
    public function __construct(string $login)
    {
        $this->login = $login;
        $this->message = "Login {$login} does not exists!";
    }

    /**
     * @return string
     */
    public function getLogin() : string 
    {
        return $this->login;
    }
}