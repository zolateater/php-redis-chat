<?php

use App\Model\User;
use App\Store\Repository\ArrayUserRepository;

/**
 * Class ArrayUserRepositoryTest
 * 
 * Пусть этот класс и будет использоваться лишь для мокинга, 
 * почему бы не убедиться, что он работает корректно?
 */
class ArrayUserRepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Тест - поиск не существующего пользователя
     * 
     * @test
     * @group unit
     * @expectedException \App\Exception\Application\Repository\UserNotFoundException
     */
    public function it_throws_an_exception_when_you_try_to_find_non_existing_user()
    {
        $repository = new ArrayUserRepository();
        $repository->find(1);
    }

    /**
     * Тест - сохранение пользователя
     * 
     * @test
     * @group unit
     * @dataProvider getUser
     */
    public function it_saves_user(User $user)
    {
        $repository = new ArrayUserRepository();
        $this->assertFalse($repository->exists(1));
        
        $repository->save($user);
        $this->assertTrue($repository->exists(1));
    }

    /**
     * @return User
     */
    public function getUser()
    {
        $user = new User("johnDoe", "John Doe");
        return [[$user]];
    }
}