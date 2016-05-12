<?php

namespace App;

use App\Exception\Application\ApplicationException;
use App\Exception\System\SystemException;
use App\Model\User;
use App\Routes\Router;
use App\Store\Factory\RepositoryCreator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

/**
 * Class Application
 * @package App
 *
 * Класс, олицетворяющий наше приложение.
 * Все просто - мы принимаем запрос, возвращает ответ.
 * Все, о чем мы уведомляем приложение - какой тип репозитория использовать для хранения данных
 */
class Application
{
    /**
     * @var Router
     */
    protected $router;
    
    /**
     * @var \App\Store\Factory\AbstractRepositoryFactory
     */
    private $repositoryFactory;

    /**
     * Application constructor.
     * 
     * @param string $databaseType 
     * @see RepositoryCreator 
     */
    public function __construct(string $databaseType)
    {
        $repositoryCreator = new RepositoryCreator();
        $this->repositoryFactory = $repositoryCreator->getFactory($databaseType);
        $this->router = new Router();
    }

    /**
     * Обработка запроса
     * 
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request) : Response
    {
        try {
            // Находим контроллер для нашего запроса
            $routeInfo = $this->router->detectCallableFor($request);
            return new Response("Route found", 200);
        }
        catch (ResourceNotFoundException $e) {
            return $this->getNotFoundResponse($e);
        }
        catch (ApplicationException $e) {
            return $this->getApplicationErrorResponse($e);
        }
        catch (SystemException $e) {
            return $this->getCriticalErrorResponse($e);
        }
    }

    /**
     * Получает пользователя, который совершает этот запрос
     *
     * @param Request $request
     * @return User|null
     */
    public function authorize(Request $request)
    {
        
    }

    public function getRepositoryFactory()
    {
        
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