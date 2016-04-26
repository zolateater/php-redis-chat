<?php

namespace App\Store\Repository;


use App\Model\Message;
use App\Store\Contracts\MessageRepositoryContract;

class RedisMessageRepository extends BaseRedisRepository implements MessageRepositoryContract
{
    const LastIdHash = 'lastMessageId';

    const MessagesHashKeyPrefix = 'message:';

    /**
     * @param int $count
     * @param int $lastMessageId
     * @return Message[]
     */
    public function getLastMessages(int $count, int $lastMessageId = 0) : array
    {
        if ($count <= 0) {
            throw new \InvalidArgumentException("Count of messages must be greater that zero!");
        }

        if ( ! $lastMessageId ) {
            // Почему плюс 1? Потому что сообщение с
            // последним ID не должно входить в список
            $lastMessageId = $this->getLastId() + 1;
        }

        // Формируем, с какого по какой ID нам выбрать
        $firstMessageId = ($lastMessageId - $count) > 0 ?
            $lastMessageId - $count : 0;


        return $this->fetchRange($firstMessageId, $count);
    }

    /**
     * @param int $startId
     * @param int $count
     * @return array
     */
    protected function fetchRange(int $startId, int $count)
    {
        // Получаем все хэши одним вызовом
        $pipeline = $this->connectionClient->pipeline();
        
        while ($count > 0) {
            $count--;
            $pipeline->hgetall($this->getMessageHashKey($startId + $count));
        }
        
        $rawArray = $pipeline->execute();
        $messages = [];

        // Создаем объекты
        foreach ($rawArray as $rawElement) {
            if ($rawElement) {
                $messages[] = $this->toMessage($rawElement);
            }
        }

        return $messages;
    }

    /**
     * Создает сообщение из массива
     *
     * @param array $messageData
     * @return Message
     */
    protected function toMessage(array $messageData)
    {
        $dateTime = new \DateTime();
        $dateTime->setTimestamp((int) $messageData['timestamp']);

        $message = new Message(
            $messageData['userId'],
            $messageData['content'],
            $dateTime
        );

        $message->setId($messageData['id']);

        return $message;
    }

    public function save(Message $message)
    {
        if ( ! $message->getId() ) {
            $message->setId($this->incrementLastId());
        }
        
        $key = $this->getMessageHashKey($message->getId());
        
        $this->connectionClient->hmset($key, [
            'id' => $message->getId(),
            'userId' => $message->getUserId(),
            'content' => $message->getContent(),
            'timestamp' => $message->getWrittenAt()->getTimestamp()
        ]);
    }

    /**
     * Возвращает id для нового сообщения
     *
     * @return int
     */
    protected function incrementLastId() : int
    {
        return $this->connectionClient->incr(static::LastIdHash);
    }

    /**
     * Возвращает ключ хэша, где хранится сообщение с переданным id
     * 
     * @param int $id
     * @return string
     */
    protected function getMessageHashKey(int $id) : string
    {
        return static::MessagesHashKeyPrefix . $id;
    }

    /**
     * Возвращает id последнего сообщения
     *
     * @return int
     */
    protected function getLastId() : int
    {
        return (int) $this->connectionClient->get(static::LastIdHash);
    }
}