<?php

namespace App\Http;


use App\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * Наша базовая страничка для
     *
     * @return string
     */
    public function index()
    {
        // Если пользователь залогинен - перенаправляем
        // его на страницу с чатом
        if ($this->currentUser) {
            return new RedirectResponse('/chat');
        }

        $view = new View('index.twig');
        return $view->render();
    }
}