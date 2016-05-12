<?php

namespace App\Routes;


use App\Exception\Application\ApplicationException;
use App\Exception\System\SystemException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class Router
 * @package App\Router
 * 
 * Прописываем приложения здесь
 */
class Router
{
    // Нам не нужны ни параметры, ни DI, ни чего либо такого.
    // Все что нам нужно - соответствие маршрута контроллеру,
    // поэтому обойдемся таким подходом.
    
    // Здесь - имя контроллера указывается как имя его класса за вычетом \App\Http
    // То есть, все контроллеры должны находится внутри этого пространства имен. 
    protected static $routes = [
        // Домашняя страница c формами регистрации
        '/' => [
            'method' => 'GET',
            'controller' => 'IndexController',
            'action' => 'index'
        ],
        // Базовая страница c чатом
        '/chat' => [
            'method' => 'GET',
            'controller' => 'ChatController',
            'action' => 'index'
        ],
        // Отправка формы регистрации
        '/registration' => [
            'method' => 'POST',
            'controller' => 'AuthController',
            'action' => 'register'
        ],
        // Отправка формы входа
        '/login' => [
            'method' => 'POST',
            'controller' => 'AuthController',
            'action' => 'login'
        ]
    ];

    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->routeCollection = new RouteCollection();

        // Добавляем маршруты в коллекцию
        foreach (static::$routes as $routeName => $routeParameters) {
            $this->routeCollection->add($routeName, new Route($routeName, [], [], [], '', [], [$routeParameters['method']]));
        }
    }

    /**
     * Определяет, какой контроллер подходит для переданного запроса
     *
     * @param Request $request
     * @return RouteInfo
     * @throws ResourceNotFoundException
     */
    public function detectCallableFor(Request $request) : RouteInfo
    {
        $context = new RequestContext();
        $context->fromRequest($request);
        $matcher = new UrlMatcher($this->routeCollection, $context);

        $attributes = $matcher->match($request->getPathInfo());
        $routeName = $attributes['_route'];
        $matchedRouteParameters = static::$routes[$routeName];
        
        return new RouteInfo($matchedRouteParameters['controller'], $matchedRouteParameters['action']);
    }

    /**
     * Обработка ошибки 404
     *
     * @param ResourceNotFoundException $exception
     * @return Response
     */
    public function getNotFoundResponse(ResourceNotFoundException $exception) : Response
    {
        return new Response("Sorry, Mario, but your page is not found", 404);
    }

    /**
     * Вернуть ответ для серьезной ошибки, мешающей работе системы
     *
     * @param SystemException  $exception
     * @return Response
     */
    public function getCriticalErrorResponse(SystemException $exception) : Response
    {
        return new Response('Something really critical just happened!', 500);
    }

    /**
     * Обработка ошибки 500
     * 
     * @param ApplicationException $exception
     * @return Response
     */
    public function getApplicationErrorResponse(ApplicationException $exception) : Response 
    {
        return new Response('Server error', 500);
    }
}