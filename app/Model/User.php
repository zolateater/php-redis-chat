<?php

namespace App\Model;

/**
 * Class User
 * @package App\Model
 *
 * User model class
 */
class User extends Model
{
    /**
     * Login of the user
     * 
     * @var string
     */
    protected $login;

    /**
     * Full name of the user
     *
     * @var string
     */
    protected $fullName;

    /**
     * Хэш пароля пользователя
     * Для простоты будем считать,
     * что он связан с пользователем
     * неразрывно
     *
     * @var string
     */
    protected $passwordHash = '';

    /**
     * User constructor.
     * 
     * @param string $login
     * @param string $fullName
     * @param string $passwordHash
     */
    public function __construct(string $login, string $fullName, string $passwordHash = '')
    {
        $this->login = $login;
        $this->fullName = $fullName;
        $this->passwordHash = '';
    }

    /**
     * @return string
     */
    public function getLogin() : string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getPasswordHash()
    {
        return $this->passwordHash;
    }

    /**
     * @param string $password
     */
    public function encryptPassword(string $password)
    {
        // Конечно, в реальном приложении следует
        // инкапуслировать генерацию хэша по паролю,
        // но ради простоты примера оставим это здесь
        $this->passwordHash = password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * Создает токен для запоминания пользователя
     * 
     * @return RememberToken
     */
    public function generateRememberToken()
    {
        return new RememberToken($this->getId());
    }

    /**
     * Удобный способ создания сообщений от имени пользователя
     * 
     * @param string $content
     * @return Message
     */
    public function writeMessage(string $content) : Message
    {
        $currentDateTime = new \DateTime();
        return new Message($this->getId(), $content, $currentDateTime);    
    }
}