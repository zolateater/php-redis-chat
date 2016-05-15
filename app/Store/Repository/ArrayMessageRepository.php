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
        if ($count <= 0) {
            throw new \InvalidArgumentException("Count of messages must be greater than zero!");
        }

        $messageCountTotal = count($this->messages);

        if (!$lastMessageId) {
            $lastMessageId = $messageCountTotal + 1;
        }

        $messagesToReturn = [];
        for ($i = $lastMessageId - 1; $i > 0; $i--) {
            $messagesToReturn[] = $this->messages[$i];

            if (count($messagesToReturn) == $count) {
                break;
            }
        }

        return $messagesToReturn;
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