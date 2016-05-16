<?php

namespace App\Http;


use App\Model\User;
use App\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ChatController extends Controller
{
    public function index()
    {
//        if ( ! $this->currentUser) {
//            return new RedirectResponse('/');
//        }
        
        $this->currentUser = new User('cherry90', 'Бомж иван');

        $view = new View("chat.twig", ['currentUser' => $this->currentUser]);
        return $view->render();
    }
}