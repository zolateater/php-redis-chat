<?php

namespace App\Store\Repository;


use App\Model\Message;
use App\Store\Contracts\MessageRepositoryContract;

class ArrayMessageRepository implements MessageRepositoryContract
{
    /**
     * @var Message[]
     */
    protected $messages = [];

    /**
     * @param int $count
     * @param int $lastMessageId
     * @return array
     */
    public function getLastMessages(int $count, int $lastMessageId = 0) : array
    {
        // TODO: Implement getLastMessages() method.
    }

    /**
     * @param Message $message
     */
    public function save(Message $message)
    {
        if (!$message->getId()) {
            $message->setId(count($this->messages) + 1);
        }
        
        $this->messages[$message->getId()] = $message;
    }


}