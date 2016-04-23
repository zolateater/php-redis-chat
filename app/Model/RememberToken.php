<?php

namespace App\Model;

/**
 * Class RememberToken
 * @package App\Model
 *
 * Токен для запоминания пользователя
 */
class RememberToken
{
    /**
     * Некоторая символьная последовательность,
     *
     * @var string
     */
    protected $token;

    /**
     * @var int
     */
    protected $userId;

    public function __construct(int $userId)
    {
        $this->userId = $userId;
        $this->token = bin2hex(random_bytes(100));
    }

    /**
     * @return string
     */
    public function getTokenValue() : string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getUserId() : int
    {
        return $this->userId;
    }
}