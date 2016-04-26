<?php

namespace App\Model;

use DateTime;

/**
 * Class Message
 * @package App\Model
 *
 * Модель, представляющая сообщение
 */
class Message extends Model
{
    /**
     * Автор сообщения
     *
     * @var int
     */
    protected $userId;

    /**
     * Содержимое сообщения
     *
     * @var string
     */
    protected $content;

    /**
     * Дата и время написания сообщения
     *
     * @var DateTime
     */
    protected $writtenAt;

    /**
     * Message constructor.
     * @param int $userId Id пользователя, от лица которого написано сообщение 
     * @param string $content содержимое
     * @param DateTime $writtenAt дата написания
     */
    public function __construct(int $userId, string $content, DateTime $writtenAt)
    {
        $this->userId = $userId;
        $this->content = $content;
        $this->writtenAt = $writtenAt;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return DateTime
     */
    public function getWrittenAt()
    {
        return $this->writtenAt;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }


}