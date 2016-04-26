<?php

namespace App\Store\Factory;


use App\Store\Contracts\MessageRepositoryContract;
use App\Store\Contracts\RememberTokenRepositoryContract;
use App\Store\Contracts\UserRepositoryContract;
use App\Store\Repository\RedisMessageRepository;
use App\Store\Repository\RedisRememberTokenRepository;
use App\Store\Repository\RedisUserRepository;
use Predis\Client;

/**
 * Class RedisRepositoryFactory
 * @package App\Store\Factory
 * 
 * Реализация фабрики репозиториев для Redis
 */
class RedisRepositoryFactory extends AbstractRepositoryFactory
{
    protected $clientConnection;

    /**
     * RedisRepositoryFactory constructor.
     * @param Client $clientConnection
     */
    public function __construct(Client $clientConnection)
    {
        $this->clientConnection = $clientConnection;
    }

    /**
     * @return MessageRepositoryContract
     */
    public function getMessageRepository() : MessageRepositoryContract
    {
        return new RedisMessageRepository($this->clientConnection);
    }

    /**
     * @return RememberTokenRepositoryContract
     */
    public function getRememberTokenRepository() : RememberTokenRepositoryContract
    {
        return new RedisRememberTokenRepository($this->clientConnection);
    }

    /**
     * @return UserRepositoryContract
     */
    public function getUserRepository() : UserRepositoryContract
    {
        return new RedisUserRepository($this->clientConnection);
    }


}