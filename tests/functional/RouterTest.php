<?php
use App\Routes\Router;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RouterTest
 * 
 * Тестирование маршрутов
 */
class RouterTest extends PHPUnit_Framework_TestCase
{
    /**
     * Тест - запрос с параметрами по умолчанию
     * 
     * @test
     */
    public function it_returns_route_info_for_index_page()
    {
        $router = new Router();
        $route = $router->detectCallableFor(new Request());

        $this->assertEquals('IndexController', $route->getControllerName());
        $this->assertEquals('index', $route->getActionName());

        $route = $router->detectCallableFor(new Request([], [], [], [], [], ['REQUEST_URI' => '/']));
        $this->assertEquals('IndexController', $route->getControllerName());
        $this->assertEquals('index', $route->getActionName());
    }

    /**
     * Тест - запрос страницы чата
     *
     * @test
     */
    public function it_returns_route_info_for_chat()
    {
        $router = new Router();
        $route = $router->detectCallableFor(new Request([], [], [], [], [], ['REQUEST_URI' => '/chat']));

        $this->assertEquals('ChatController', $route->getControllerName());
        $this->assertEquals('index', $route->getActionName());
    }

    /**
     * @test
     * @expectedException \Symfony\Component\Routing\Exception\ResourceNotFoundException
     */
    public function it_throws_exception_if_route_not_found()
    {
        $router = new Router();
        $route = $router->detectCallableFor(new Request([], [], [], [], [], ['REQUEST_URI' => '/nonExistingPage']));
    }
}