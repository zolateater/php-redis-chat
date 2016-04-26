<?php

namespace App\Store\Repository;


use App\Exception\Application\Repository\TokenDoesNotExistException;
use App\Model\RememberToken;
use App\Store\Contracts\RememberTokenRepositoryContract;

/**
 * Class ArrayRememberTokenRepository
 * @package App\Store\Repository
 * 
 * Реализация контракта репозитория для хранения в массиве.
 * Используется для тестов, чтобы не писать в реальный репозиторий.
 */
class ArrayRememberTokenRepository implements RememberTokenRepositoryContract
{
    protected $tokens = [];

    /**
     * Есть ли такой токен для запоминания
     * 
     * @param string $token
     * @return bool
     */
    public function exists(string $token) : bool
    {
        return array_key_exists($token, $this->tokens);
    }

    /**
     * Получить ID пользователя, 
     * для которого сгенерирован данный токен
     * 
     * @param string $tokenValue
     * @return int
     * @throws TokenDoesNotExistException
     */
    public function getOwnerId(string $tokenValue) : int
    {
        if (!$this->exists($tokenValue)) {
            throw new TokenDoesNotExistException;
        }
    }

    /**
     * @param RememberToken $token
     */
    public function save(RememberToken $token)
    {
        $this->tokens[$token->getTokenValue()] = $token;
    }
}