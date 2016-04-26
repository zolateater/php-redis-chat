<?php

namespace App;

use App\Model\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

use App\Exception\Application\ApplicationException;
use App\Exception\System\SystemException;

/**
 * Class Application
 * @package App
 *
 * Класс, олицетворяющий наше приложение.
 * По сути, мы проверяем - залогинен ли пользователь,
 * вызываем какой-то метод... и все.
 */
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

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Ну, это конечно же для тестирования
     * Мы можем сгенерировать некоторый запрос, и установить его нашему приложению
     *
     * @param Request $request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Указываем здесь все uri в нашем приложении
     */
    protected function bootstrapRoutes()
    {
        $this->routeCollection = new RouteCollection();

        // Наша страница чата
        $this->routeCollection->add('chatPage', new Route('', [], [], [], '', [], ['GET']));
        // Страница, где нужно залогиниться
        $this->routeCollection->add('signInPage', new Route('/login', [], [], [], '', [], ['GET']));
        // Отправка формы регистрации
        $this->routeCollection->add('registration', new Route('/register', [], [], [], '', [], 'POST'));
        // Отправка формы входа
        $this->routeCollection->add('login', new Route('/register', [], [], [], '', [], ['POST']));
    }

    public function bootstrap()
    {
        $this->bootstrapRoutes();
    }

    /**
     * @return Response
     */
    public function getResponse() : Response
    {
        $context = new RequestContext();
        $context->fromRequest($this->request);
        $matcher = new UrlMatcher($this->routeCollection, $context);

        try {
            $attributes = $matcher->match($this->request->getPathInfo());
            $routeName = $attributes['_route'];
            
            return new Response($routeName, 200);
        }
        catch (ResourceNotFoundException $e) {
            return new Response("Sorry, Mario, but your page is not found", 404);
        }
        catch (ApplicationException $e) {
            return new Response($e->getMessage(), 500);
        }
        catch (SystemException $e) {
            return new Response("Something really critical just happened", 500);
        }
    }

    /**
     * Для простоты будем считать, что у нас всего один контроллер, 
     * количество action не будет меняться
     * 
     * @param string $action
     */
    protected function callAction(string $action)
    {
        
    }
}