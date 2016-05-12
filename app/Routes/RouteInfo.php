<?php

namespace App\Routes;

/**
 * Class RouteInfo
 * 
 * Класс, содержаший информацию о контроллере и его методе, 
 * подходящем для маршрута.
 * 
 * @package App\Routes
 */
class RouteInfo
{
    /**
     * @var string
     */
    private $controllerName;
    /**
     * @var string
     */
    private $actionName;

    public function __construct(string $controllerName, string $actionName)
    {

        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
    }

    /**
     * @return string
     */
    public function getActionName() : string
    {
        return $this->actionName;
    }

    /**
     * @return string
     */
    public function getControllerName() : string
    {
        return $this->controllerName;
    }

    /**
     * Возвращает полное имя класса контроллера
     *
     * @return string
     */
    public function getFullClassName() : string
    {
        return "\\App\\Http\\" . $this->getControllerName();
    }
}