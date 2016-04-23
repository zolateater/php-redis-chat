<?php

namespace App\Store\Contracts;


use App\Model\User;

/**
 * Interface UserRepositoryContract
 * @package App\Store\Repository
 * 
 * Интерфейс, который должно реализовывать выбранное нами 
 * хранилище пользователей 
 */
interface UserRepositoryContract
{
    /**
     * Получить пользователя по ID
     *
     * @param $id
     * @return User
     */
    public function find(int $id) : User;

    /**
     * Определение - существует ли пользователь с таким ID
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id) : bool;

    /**
     * Сохраняет пользователя
     * 
     * @param User $user
     */
    public function save(User $user);

    /**
     * Метод проверки существования логина
     * 
     * @param string $login
     * @return bool
     */
    public function loginExists(string $login) : bool;

    /**
     * Получить пользователя по его логину
     * 
     * @param string $login
     * @return User
     */
    public function fetchByLogin(string $login) : User;
    
}