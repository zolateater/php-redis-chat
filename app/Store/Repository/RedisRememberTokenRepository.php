<?php

namespace App\Store\Repository;


use App\Exception\Application\Repository\TokenDoesNotExistException;
use App\Model\RememberToken;
use App\Store\Contracts\RememberTokenRepositoryContract;

/**
 * Class RedisRememberTokenRepository
 * @package App\Store\Repository
 * 
 * Класс репозитория для хранения токенов для авторизации в Redis. 
 */
class RedisRememberTokenRepository extends BaseRedisRepository implements RememberTokenRepositoryContract 
{
    const HashKey = 'auth';

    /**
     * Получить id пользователя по токену
     * 
     * @param string $tokenValue
     * @return int
     * @throws TokenDoesNotExistException
     */
    public function getOwnerId(string $tokenValue) : int
    {
        if ( ! $this->exists($tokenValue) ) {
            throw new TokenDoesNotExistException($tokenValue);
        }
        
        return (int) $this->connectionClient->hget(static::HashKey, $tokenValue);
    }

    /**
     * Сущестует ли в нашей базе данных Redis такой токен?
     * 
     * @param string $token
     * @return bool
     */
    public function exists(string $token) : bool
    {
        return $this->connectionClient->hexists(static::HashKey, $token);
    }

    /**
     * Сохраняем в Redis такой вот токен
     *
     * @param RememberToken $token
     */
    public function save(RememberToken $token)
    {
        $this->connectionClient->hset(static::HashKey, $token->getTokenValue(), $token->getUserId());
    }
}