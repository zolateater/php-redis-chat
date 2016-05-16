<?php

namespace App;

use App\Auth\Authorizer;
use App\Auth\RequestWithCookie;
use App\Exception\Application\ApplicationException;
use App\Exception\System\SystemException;
use App\Model\User;
use App\Routes\Router;
use App\Store\Contracts\MessageRepositoryContract;
use App\Store\Contracts\RememberTokenRepositoryContract;
use App\Store\Contracts\UserRepositoryContract;
use App\Store\Factory\RepositoryCreator;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Throwable;

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
     * @var Authorizer
     */
    protected $authorizer;
    
    /**
     * Application constructor.
     * 
     * @param string $databaseType 
     * @see RepositoryCreator 
     */
    public function __construct(string $databaseType)
    {
        $repositoryCreator = new RepositoryCreator();
        $this->router = new Router();

        $repositoryFactory = $repositoryCreator->getFactory($databaseType);

        $this->userRepository = $repositoryFactory->getUserRepository();
        $this->tokenRepository = $repositoryFactory->getRememberTokenRepository();
        $this->messageRepository = $repositoryFactory->getMessageRepository();
    }

    /**
     * Обработка HTTP запроса
     * 
     * @param Request $request
     * @return Response
     */
    public function handleRequest(Request $request) : Response
    {
        try {
            // Находим контроллер для нашего запроса
            $routeInfo = $this->router->detectCallableFor($request);
            
            // Имя класса-контроллера
            $controllerClass = $routeInfo->getFullClassName();
            
            // Создаем наш контроллер
            $controller = new $controllerClass(
                $request, 
                $this->userRepository,
                $this->tokenRepository,
                $this->messageRepository,    
                $this->authorize(RequestWithCookie::createFromHttpRequest($request))
            );
            
            // Вызываем action
            $actionName = $routeInfo->getActionName();
            $responseData = $controller->$actionName();
            
            // Если мы уже вернули Response, из action'a то ничего больше не надо 
            if ($responseData instanceof Response) {
                return $responseData;
            }
            
            return new Response($responseData, 200);
        }
        // 404
        catch (ResourceNotFoundException $e) {
            return $this->getNotFoundResponse($e);
        }
        // Ошибка приложения. Здесь мы должны справиться.
        catch (ApplicationException $e) {
            return $this->getApplicationErrorResponse($e);
        }
        // Критическая ошибка
        catch (SystemException $e) {
            return $this->getCriticalErrorResponse($e);
        }
        // Неотловленное исключение
        catch (Throwable $e) {
            return $this->getUnhandledExceptionResponse($e);
        }
    }

    /**
     * Получает пользователя, который совершает этот запрос
     *
     * @param RequestWithCookie $request
     * @return User|null
     */
    public function authorize(RequestWithCookie $request)
    {
        $authorizer = new Authorizer();
        return $authorizer->authorize(
            $request,
            $this->getTokenRepository(), 
            $this->getUserRepository()
        );
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

    /**
     * Обработка неотловленных исключений (ошибка 500)
     *
     * TODO: сделать переключалку и конфиг
     * @param Throwable $e
     * @return string
     */
    private function getUnhandledExceptionResponse(Throwable $e)
    {
        dump($e);
        return "Unhandled Exception occured!<br />";
    }

    /**
     * @return UserRepositoryContract
     */
    public function getUserRepository()
    {
        return $this->userRepository;
    }

    /**
     * @return RememberTokenRepositoryContract
     */
    public function getTokenRepository()
    {
        return $this->tokenRepository;
    }

    /**
     * @return MessageRepositoryContract
     */
    public function getMessageRepository()
    {
        return $this->messageRepository;
    }
}