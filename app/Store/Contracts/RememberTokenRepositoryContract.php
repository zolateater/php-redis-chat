<?php

namespace App\Store\Contracts;


use App\Exception\Application\Repository\TokenDoesNotExistException;
use App\Model\RememberToken;

interface RememberTokenRepositoryContract
{
    /**
     * Существует ли такой токен для запоминания пользователя?
     * 
     * @param string $token
     * @return bool
     */
    public function exists(string $token) : bool;

    /**
     * Получить ID пользователя, ассоциированного с этим токеном
     *
     * @param string $tokenValue
     * @return int
     * @throws TokenDoesNotExistException
     */
    public function getOwnerId(string $tokenValue) : int;

    /**
     * Сохранить токен для запоминания
     * 
     * @param RememberToken $token
     */
    public function save(RememberToken $token);
}