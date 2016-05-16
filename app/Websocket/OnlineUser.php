<?php

namespace App\Websocket;


use App\Model\User;
use Ratchet\ConnectionInterface;

/**
 * Class OnlineUser
 * @package App\Websocket
 * 
 * Класс композиция.
 * Служит для ассоциации конкретного пользователя из базы данных с соединением  
 */
class OnlineUser
{
    protected $connection;

    protected $userModel;

    /**
     * OnlineUser constructor.
     * @param ConnectionInterface $connection
     * @param User $user
     */
    public function __construct(ConnectionInterface $connection, User $user)
    {
        $this->connection = $connection;
        $this->userModel = $user;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return User
     */
    public function getUserModel()
    {
        return $this->userModel;
    }
}