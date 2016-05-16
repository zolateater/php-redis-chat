<?php

namespace App\Auth;
use Guzzle\Http\Message\EntityEnclosingRequest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestWithCookie
 * @package App\Auth
 * 
 * Данный класс служит оберткой над запросами и унификации работы с куками.
 * У нас есть несколько типов запросов:
 * 1) HTTP запрос (для этого мы используем) Request из Symfony
 * 2) Запрос Handshake к серверу Websocket, из пакета Guzzle
 * Для обоих типов нам нужна исключительно работа с куками для возможности авторизации по ним.
 * Поэтому мы используем свою обертку, позволяющую получать cookie из обоих типов запросов. 
 */
class RequestWithCookie
{
    protected $cookies = [];

    public function __construct(array $cookies = [])
    {
        $this->cookies = $cookies;
    }

    /**
     * Создает запрос с куками из HTTP запроса
     * 
     * @param Request $request
     * @return RequestWithCookie
     */
    public static function createFromHttpRequest(Request $request) : RequestWithCookie
    {
        return new static($request->cookies->all());
    }

    /**
     * Создает запрос с куками из Handshake запроса
     *
     * @param EntityEnclosingRequest $request
     * @return RequestWithCookie
     */
    public static function createFromWebSocketRequest(EntityEnclosingRequest $request) : RequestWithCookie
    {
        return new static($request->getCookies());
    }

    /**
     * Получить значение куки по ключу
     * 
     * @param string $key
     * @param string $default
     * @return string
     */
    public function get(string $key, string $default = '') : string
    {
        if (array_key_exists($key, $this->cookies)) {
            return $this->cookies[$key];
        }
        
        return $default;
    }
}