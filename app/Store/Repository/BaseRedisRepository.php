<?php

namespace App\Store\Repository;


use Predis\Client;

abstract class BaseRedisRepository
{
    /**
     * @var Client
     */
    protected $connectionClient;

    public function __construct(Client $client)
    {
        $this->connectionClient = $client;
    }
}