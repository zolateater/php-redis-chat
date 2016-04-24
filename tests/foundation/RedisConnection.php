<?php


trait RedisConnection 
{
    public function getTestConnection()
    {
        // TODO: Возможность задать тестовое соединение с БД
        return new \Predis\Client();
    }

    public function flushDb()
    {
        $this->getTestConnection()->flushdb();
    }
}