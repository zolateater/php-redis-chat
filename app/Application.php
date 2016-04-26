<?php

namespace App;


use App\Model\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouteCollection;

class Application
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * Залогиненный пользователь
     * 
     * @var User
     */
    protected $user;
    
    
    protected function bootstrap()
    {
        // TODO: add routes and bootstrap application
    }
    
    public function __construct()
    {
        
    }
}