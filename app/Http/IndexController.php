<?php

namespace App\Http;


class IndexController extends Controller
{
    public function index()
    {
        return $this->renderView('layout.twig');
    }
}