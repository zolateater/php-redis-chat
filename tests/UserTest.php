<?php

use App\Model\User;
use App\Store\Repository\ArrayUserRepository;

class UserTest extends PHPUnit_Framework_TestCase
{
    /**
     * Тест - хранение и получение данных в объекте пользователя
     *
     * @test
     * @group unit
     */
    public function it_can_store_base_info()
    {
        $user = new User('johnnyCage90', 'Johnny Cage');

        $this->assertEquals($user->getLogin(), 'johnnyCage90');
        $this->assertEquals($user->getFullName(), 'Johnny Cage');
    }

    /**
     * Тест - хеширование пароля пользователя
     *
     * @test
     * @group unit
     */
    public function it_hashes_its_password()
    {
        $user = new User('anotherUser', 'John Doe');

        // It is empty by default
        $this->assertEmpty($user->getPasswordHash());
        $user->encryptPassword('12345678');

        $this->assertNotEquals('12345678', $user->getPasswordHash());
        $this->assertNotEmpty($user->getPasswordHash());

        $this->assertTrue(password_verify('12345678', $user->getPasswordHash()));
    }

    /**
     * Тест - создание токена для запоминания
     * пользователем, который существует
     *
     * @test
     * @group unit
     */
    public function it_can_create_token_for_remembering()
    {
        $user = new User("JohnDoe", "John Doe");

        $repo = new ArrayUserRepository();
        $repo->save($user);

        $token = $user->generateRememberToken();
        $this->assertEquals($token->getUserId(), $user->getId());
    }
}