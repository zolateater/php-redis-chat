<?php

namespace App\Store\Factory;
use App\Exception\System\UnknownRepositoryType;
use Predis\Client;


/**
 * Class RepositoryCreator
 * @package App\Store\Factory
 * 
 * Содержит исключительно фабричный метод для создания фабрики репозиториев, 
 * так как указывать тип хранения мы будем лишь единожды - в некотором конфиге.
 */
class RepositoryCreator
{
    /**
     * Допустимые значения -
     * array - для репозитория, где все хранится в массиве - на вреся тестов
     * redis - для репозитория с redis
     * 
     * @param string $type
     * @return AbstractRepositoryFactory
     * @throws UnknownRepositoryType
     */
    public function getFactory(string $type) : AbstractRepositoryFactory
    {
        if ($type == 'array') {
            return new ArrayRepositoryFactory();
        }
        if ($type == 'redis') {
            // В данном приложении мы используем
            // исключительно соединение по умолчанию, 
            // Однако, в реальном приложении,
            // конечно же стоит ввести понятие соединения.
            return new RedisRepositoryFactory(new Client());
        }
        throw new UnknownRepositoryType($type);
    }
}