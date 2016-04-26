<?php

namespace App\Store\Factory;


use App\Store\Contracts\MessageRepositoryContract;
use App\Store\Contracts\RememberTokenRepositoryContract;
use App\Store\Contracts\UserRepositoryContract;

/**
 * Class AbstractRepositoryFactory
 * @package App\Store\Factory
 * 
 * Определяем фабрику для создания репозиториев
 */
abstract class AbstractRepositoryFactory
{
    /**
     * Получить репозиторий, где хранятся сообщения
     * 
     * @return MessageRepositoryContract
     */
    abstract public function getMessageRepository() : MessageRepositoryContract;

    /**
     * Получить репозиторий, где хранятся пользователи
     * 
     * @return UserRepositoryContract
     */
    abstract public function getUserRepository() : UserRepositoryContract;


    /**
     * Получить репозиторий, в котором хранятся токены для запоминания
     * 
     * @return RememberTokenRepositoryContract
     */
    abstract public function getRememberTokenRepository() : RememberTokenRepositoryContract;
}