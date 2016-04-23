<?php

namespace App\Store\Contracts;


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
     * @return int
     * @throws 
     */
    public function getOwnerId() : int;

    /**
     * Сохранить токен для запоминания
     * 
     * @param RememberToken $token
     * @return mixed
     */
    public function save(RememberToken $token);
}