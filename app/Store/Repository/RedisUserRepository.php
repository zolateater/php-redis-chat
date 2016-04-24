<?php
/**
 * Created by PhpStorm.
 * User: zolat
 * Date: 23.04.16
 * Time: 23:27
 */

namespace App\Store\Repository;


use App\Exception\Application\Repository\LoginDoesNotExistsException;
use App\Exception\Application\Repository\UserNotFoundException;
use App\Model\User;
use App\Store\Contracts\UserRepositoryContract;
/**
 * Class RedisUserRepository
 * @package App\Store\Repository
 */
class RedisUserRepository extends BaseRedisRepository implements UserRepositoryContract
{
    /**
     * Префикс ключа хэша, в котором хранятся данные о пользователе.
     */
    const UserHashPrefix = 'user:';

    /**
     * По этому ключу мы храним id последнего пользователя
     */
    const LastUserIdKey = 'lastUserId';

    /**
     * По этому ключу мы храним хэш,
     * в котором ключ - имя пользователя, значение - его id
     */
    const LoginHashKey = 'users';

    /**
     * Есть ли такой пользователь в нашей коллекции?
     *
     * @param int $id
     * @return bool
     */
    public function exists(int $id) : bool
    {
        return $this->connectionClient->exists($this->getUserHash($id));
    }

    /**
     * Ищем пользователя по его id
     *
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function find(int $id) : User
    {
        // Здесь мы, очевидно, делаем лишнюю операцию,
        // но для простоты примера пусть будет так
        if ( ! $this->exists($id) ) {
            throw new UserNotFoundException($id);
        }
        
        $userKey = $this->getUserHash($id); 
        
        $userHash = $this->connectionClient->hgetall($userKey);
        
        $user = new User($userHash['login'], $userHash['fullName'], $userHash['passwordHash']);
        $user->setId($id);
        
        return $user;
    }

    /**
     * Определяем, есть у нас пользователь с таким логином
     *
     * @param string $login
     * @return bool
     */
    public function loginExists(string $login) : bool
    {
        return $this->connectionClient->hexists(static::LoginHashKey, $login);
    }

    /**
     * Сохраняем пользователя
     *
     * @param User $user
     */
    public function save(User $user)
    {
        if ( ! $user->getId()) {
            $newId = $this->incrementLastId();
            $user->setId($newId);
        }
        
        // Сохраняем сопоставление логина пользователя его id 
        $this->saveLogin($user->getId(), $user->getLogin());

        // В каком хэше мы будем хранить пользователя?
        $userHashKey = $this->getUserHash($user->getId());
        
        $this->connectionClient->hmset($userHashKey, [
            'login' => $user->getLogin(),
            'fullName' => $user->getFullName(),
            'passwordHash' => $user->getPasswordHash()
        ]);
    }

    /**
     * Находим пользователя по логину
     * 
     * @param string $login
     * @return User
     * @throws LoginDoesNotExistsException
     * @throws UserNotFoundException
     */
    public function fetchByLogin(string $login) : User
    {
        if ( ! $this->loginExists($login)) {
            throw new LoginDoesNotExistsException($login);
        }

        // Находим id по логину из отдельной коллекции
        $userId = (int) $this->connectionClient->hget(static::LoginHashKey, $login);
        
        return $this->find($userId);
    }


    /**
     * Сохраняет сопоставление логина с id
     *
     * @param int $id
     * @param string $login
     */
    protected function saveLogin(int $id, string $login)
    {
        $this->connectionClient->hset(static::LoginHashKey, $login, $id);
    }

    /**
     * Имя ключа, под которым хранится наш пользователь
     *
     * @param int $id
     * @return string
     */
    protected function getUserHash(int $id) : string
    {
        return static::UserHashPrefix . $id;
    }

    /**
     * Инкрементируем последний ID пользователя
     * и возвращаем его новое значение
     *
     * @return int
     */
    protected function incrementLastId() : int
    {
        return $this->connectionClient->incr(static::LastUserIdKey);
    }
}