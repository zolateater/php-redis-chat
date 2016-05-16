<?php

namespace App\Http;


use App\Model\User;
use App\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ChatController extends Controller
{
    /**
     * Наша страница с чатом
     *
     * @return string|RedirectResponse
     */
    public function index()
    {
        if ( ! $this->currentUser) {
            return new RedirectResponse('/');
        }

        $view = new View("chat.twig", ['currentUser' => $this->currentUser]);
        return $view->render();
    }
}