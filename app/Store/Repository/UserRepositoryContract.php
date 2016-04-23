<?php

namespace App\Store\Repository;


use App\Model\User;

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
     * @param string $login
     * @return bool
     */
    public function loginExists(string $login) : bool;
}