<?php

namespace App\Http;
use App\Model\User;
use Guzzle\Http\Message\Request;

/**
 * Class Controller
 * @package App\Http
 *
 * Наш базовый игрушечный контроллер.
 * Содержит залогиненного пользователя, текущий Request.
 */
abstract class Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var User|null
     */
    protected $currentUser;
    
    public function __construct(Request $request, User $user = null)
    {
        $this->request = $request;
        $this->currentUser = $user;
    }
}