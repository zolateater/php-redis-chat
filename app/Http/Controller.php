<?php

namespace App\Http;
use App\Application;
use App\Model\User;
use App\Store\Contracts\MessageRepositoryContract;
use App\Store\Contracts\RememberTokenRepositoryContract;
use App\Store\Contracts\UserRepositoryContract;
use Symfony\Component\HttpFoundation\Request;
use Twig_Environment;
use Twig_Loader_Filesystem;

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

    /**
     * @var UserRepositoryContract
     */
    protected $userRepository;

    /**
     * @var RememberTokenRepositoryContract
     */
    protected $tokenRepository;

    /**
     * @var MessageRepositoryContract
     */
    protected $messageRepository;

    /**
     * Ух, какой большущий конструктор вышел.
     * 
     * Controller constructor.
     * 
     * @param Request $request
     * @param UserRepositoryContract $userRepository
     * @param RememberTokenRepositoryContract $tokenRepository
     * @param MessageRepositoryContract $messageRepository
     * @param User|null $user
     * @internal param AbstractRepositoryFactory $factory
     */
    public function __construct(
        Request $request, 
        UserRepositoryContract $userRepository,
        RememberTokenRepositoryContract $tokenRepository,
        MessageRepositoryContract $messageRepository,    
        User $user = null)
    {
        $this->request = $request;
        $this->currentUser = $user;
        $this->userRepository = $userRepository;
        $this->tokenRepository = $tokenRepository;
        $this->messageRepository = $messageRepository;
    }
}