<?php
/**
 * Created by PhpStorm.
 * User: zolat
 * Date: 24.04.16
 * Time: 4:27
 */

namespace App\Exception\Application\Repository;


use App\Exception\Application\ApplicationException;
use Exception;

class LoginDoesNotExistsException extends ApplicationException
{
    public function __construct(string $login)
    {
        $this->message = "Login {$login} does not exists!";
    }

}