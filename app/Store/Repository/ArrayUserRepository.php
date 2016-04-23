<?php

namespace App\Store\Repository;

use App\Model\User;

class ArrayUserRepository implements UserRepositoryContract
{
    /**
     * @var User[]
     */
    protected $users;
    
    public function exists(int $id) : bool
    {
        return array_key_exists($this->users, (string) $id);
    }

    public function find(int $id) : User
    {
        return 1;
    }

    public function save(User $user)
    {
        // TODO: Implement save() method.
    }


}