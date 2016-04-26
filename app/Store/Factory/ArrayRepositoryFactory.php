<?php

namespace App\Store\Factory;


use App\Store\Contracts\MessageRepositoryContract;
use App\Store\Contracts\RememberTokenRepositoryContract;
use App\Store\Contracts\UserRepositoryContract;
use App\Store\Repository\ArrayMessageRepository;
use App\Store\Repository\ArrayRememberTokenRepository;
use App\Store\Repository\ArrayUserRepository;

/**
 * Class ArrayRedisFactory
 * @package App\Store\Factory
 * 
 * Реализация фабрики репозиториев для хранения в массиве.
 */
class ArrayRepositoryFactory extends AbstractRepositoryFactory
{
    public function getMessageRepository() : MessageRepositoryContract
    {
        return new ArrayMessageRepository();
    }

    public function getRememberTokenRepository() : RememberTokenRepositoryContract
    {
        return new ArrayRememberTokenRepository();
    }

    public function getUserRepository() : UserRepositoryContract
    {
        return new ArrayUserRepository();
    }


}