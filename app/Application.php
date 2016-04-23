<?php

namespace App;

use Store\Repository\UserRepositoryContract;

class Application
{
    protected $request;

    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;
    
    
    protected function bootstrap()
    {
        
    }
    
    public function __construct()
    {
        $this->bootstrap();
    }

}