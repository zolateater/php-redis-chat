<?php
use App\Routes\RouteInfo;

/**
 * Created by PhpStorm.
 * User: zolat
 * Date: 12.05.16
 * Time: 0:13
 */
class RouteInfoTest extends PHPUnit_Framework_TestCase
{
    /**
     * Тест - получение переданных параметров
     *
     * @test
     */
    public function it_stores_passed_controller_and_action()
    {
        $routeInfo = new RouteInfo('TestController', 'testAction');

        $this->assertEquals('TestController', $routeInfo->getControllerName());
        $this->assertEquals('testAction', $routeInfo->getActionName());
    }

    /**
     * Тест - получение полного имени класса контроллера
     * 
     * @test
     */
    public function it_returns_full_class_name()
    {
        $routeInfo = new RouteInfo('Controller', 'testAction');
        $this->assertTrue(class_exists($routeInfo->getFullClassName()));
    }
}