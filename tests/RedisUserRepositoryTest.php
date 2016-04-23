<?php
use App\Model\User;
use App\Store\Repository\RedisUserRepository;
use Predis\Client;

/**
 * Class RedisUserRepositoryTest
 * Для этих тестов понадобится соединение с Redis
 * Исключены из списка тестов по умолчанию, так как они небезопасны
 */
class RedisUserRepositoryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $connection = $this->getTestConnection()[0][0];
        $connection->flushdb();
    }

    /**
     * Для этого теста понадобится соединение с Redis
     *
     * @test
     * @group Redis
     * @dataProvider getTestConnection
     * @param Client $connection
     */
    public function it_stores_a_user_and_allows_to_retrieve_it(Client $connection)
    {
        $repository = new RedisUserRepository($connection);

        $this->assertFalse($repository->loginExists('johnDoe'));
        $this->assertFalse($repository->exists(1));

        $user = new User('johnDoe', 'John Doe');
        $repository->save($user);

        $this->assertTrue($repository->loginExists('johnDoe'), 'Login exists');
        $this->assertTrue($repository->exists(1));

        $user = $repository->find(1);
        $this->assertEquals($user->getLogin(), 'johnDoe');
        $this->assertEquals($user->getFullName(), 'John Doe');
        $this->assertEquals($user->getId(), 1);

        $user = $repository->fetchByLogin('johnDoe');

        $this->assertEquals($user->getId(), 1);
        $this->assertEquals($user->getLogin(), 'johnDoe');
        $this->assertEquals($user->getFullName(), 'John Doe');
    }

    /**
     * Поиск несуществующего пользователя
     *
     * @test
     * @dataProvider getTestConnection
     * @expectedException \App\Exception\Application\Repository\UserNotFoundException
     * @group Redis
     * @param Client $connection
     */
    public function it_throw_an_exception_if_trying_to_retrieve_not_existing_user(Client $connection)
    {
        $repository = new RedisUserRepository($connection);
        $repository->find(99999);
    }

    /**
     * Поиск пользователя по несуществующему логину
     *
     * @test
     * @dataProvider getTestConnection
     * @expectedException \App\Exception\Application\Repository\LoginDoesNotExistsException
     * @group Redis
     * @param Client $connection
     */
    public function it_throws_an_exception_when_fetching_user_by_not_existing_id(Client $connection)
    {
        $repository = new RedisUserRepository($connection);
        $repository->fetchByLogin('Vitya012341234');
    }

    public function getTestConnection()
    {
        // TODO: Возможность задать тестовое соединение с БД
        return [
            [new Client()]
        ];
    }
}