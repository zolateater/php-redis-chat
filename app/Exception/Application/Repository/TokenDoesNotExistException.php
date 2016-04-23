<?php

namespace App\Exception\Application\Repository;

use App\Exception\Application\ApplicationException;

class TokenDoesNotExistException extends ApplicationException
{
    public function __construct()
    {
        parent::__construct("Provided token does not exist");
    }

}