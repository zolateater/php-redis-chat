<?php

namespace App\Store\Contracts;

use App\Model\Message;

/**
 * Interface MessageRepositoryContract
 * @package App\Store\Contracts
 *
 * Что нам нужно для сообщений?
 */
interface MessageRepositoryContract
{
    /**
     * Получить последние n сообщений.
     * Если сообщение меньше n - должно возвращаться столько, сколько есть.
     *
     * @param int $count
     * @param int $lastMessageId сообщение, которое считать последним
     * @return Message[]
     */
    public function getLastMessages(int $count, int $lastMessageId = 0) : array;
    
    
    /**
     * Сохраняет сообщение
     *
     * @param Message $message
     */
    public function save(Message $message);

}