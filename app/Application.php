<?php

namespace App;

use App\Store\Contracts\UserRepositoryContract;
use App\Store\Repository\RedisUserRepository;
use Predis\Client;

class Application
{
    protected $request;

    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;
    

    protected function bootstrap()
    {
        // TODO: make factory
        $this->userRepository = new RedisUserRepository(new Client());
    }
    
    public function __construct()
    {
        $this->bootstrap();
    }

}