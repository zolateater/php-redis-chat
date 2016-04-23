<?php

namespace App\Store\Repository;

use App\Exception\Application\Repository\UserNotFoundException;
use App\Model\User;

/**
 * Class ArrayUserRepository
 * @package App\Store\Repository
 * 
 * This repository is for mocking purposes
 */
class ArrayUserRepository implements UserRepositoryContract
{
    /**
     * @var User[]
     */
    protected $users = [];

    /**
     * @param int $id
     * @return bool
     */
    public function exists(int $id) : bool
    {
        return array_key_exists($id, $this->users);
    }

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function find(int $id) : User
    {
        if (!$this->exists($id)) {
            throw new UserNotFoundException($id);
        }
        
        return $this->users[$id];
    }

    /**
     * Saves user
     * 
     * @param User $user
     */
    public function save(User $user)
    {
        if ( ! $user->getId() ) {
            $user->setId($this->getIdForNewUser());
        }
        
        $this->users[$user->getId()] = $user;
    }

    /**
     * Генерируем новый ID для пользователя
     * 
     * @return int
     */
    protected function getIdForNewUser() : int
    {
        return count($this->users) + 1;
    }

    /**
     * Определение существования такого логина
     * 
     * @param string $login
     * @return bool
     */
    public function loginExists(string $login) : bool
    {
        return false;
    }


}