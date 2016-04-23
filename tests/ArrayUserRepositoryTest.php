<?php

use App\Store\Repository\ArrayUserRepository;

class ArrayUserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Тест - поиск не существующего пользователя
     * 
     * @test
     * @expectedException \App\Exception\Application\Repository\UserNotFoundException
     */
    public function it_throws_an_exception_when_you_try_to_find_non_existing_user()
    {
        $repository = new ArrayUserRepository();
        $repository->find(1);
    }
}