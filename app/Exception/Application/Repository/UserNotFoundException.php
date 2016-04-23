<?php

namespace App\Exception\Application\Repository;


use App\Exception\Application\ApplicationException;
use Exception;

class UserNotFoundException extends ApplicationException
{
    public function __construct($userId)
    {
        $this->message = "User with id = {$userId} not found in storage";  
    }
}