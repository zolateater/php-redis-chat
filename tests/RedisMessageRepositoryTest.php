<?php
use App\Model\Message;
use App\Store\Repository\RedisMessageRepository;

/**
 * Class RedisMessageRepositoryTest
 * 
 * Тесты для репозитория сообщений Redis
 */
class RedisMessageRepositoryTest extends PHPUnit_Framework_TestCase
{
    use RedisConnection;

    public function setUp()
    {
        $this->flushDb();
    }

    /**
     * Тест - сохранение сообщения, и его получение
     * 
     * @test
     */
    public function it_saves_message_and_allows_to_retrieve_it()
    {
        $repo = new RedisMessageRepository($this->getTestConnection());
        
        $message = new Message(1, "Some content", new DateTime());

        $lastMessages = $repo->getLastMessages(1);
        $this->assertEquals(0, count($lastMessages));

        $repo->save($message);

        $lastMessages = $repo->getLastMessages(1);
        $lastMessageFromRepo = $lastMessages[0];

        // Сообщение выглядит точно также
        $this->assertEquals($message->getUserId(), $lastMessageFromRepo->getUserId());
        $this->assertEquals($message->getContent(), $lastMessageFromRepo->getContent());
        $this->assertEquals($message->getWrittenAt()->getTimestamp(), $lastMessageFromRepo->getWrittenAt()->getTimestamp());
    }

    /**
     * Тест - если запросить 0 ошибок, то вернется лишь исключение.
     * 
     * @test
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Count of messages must be greater that zero!
     */
    public function it_throws_exception_if_count_of_last_messages_equals_zero()
    {
        $repo = new RedisMessageRepository($this->getTestConnection());
        $repo->getLastMessages(0);
    }

    /**
     * Тест - репозиторий не содержит столько сообщений, сколько запрошено,
     * поэтому вернем сколько есть
     * 
     * @test
     */
    public function it_returns_less_messages_if_in_repo_is_not_full_enough()
    {
        $repo = new RedisMessageRepository($this->getTestConnection());
        
        for ($i = 0; $i < 20; $i++) {
            $message = new Message($i, "test " . $i, new DateTime());
            $repo->save($message);
        }
        
        $lastMessages = $repo->getLastMessages(100);
        
        $this->assertCount(20, $lastMessages);
    }

    /**
     * Тест - возврат сообщений, начиная с некоторого последнего ID
     * Тест - порядок сообщений
     * 
     * @test
     */
    public function it_returns_messages_starting_from_some_id()
    {
        $repo = new RedisMessageRepository($this->getTestConnection());

        for ($i = 0; $i < 30; $i++) {
            $message = new Message($i, "test " . $i, new DateTime());
            $repo->save($message);
        }

        $lastMessages = $repo->getLastMessages(10, 21);

        // Два случая, когда количество
        // запрошенных сообщений можно получить
        $this->assertCount(10, $lastMessages);
        $this->assertEquals($lastMessages[0]->getId(), 20);
        $this->assertEquals($lastMessages[9]->getId(), 11);
        
        $lastMessages = $repo->getLastMessages(10, 11);

        $this->assertCount(10, $lastMessages);
        $this->assertEquals($lastMessages[0]->getId(), 10);
        $this->assertEquals($lastMessages[9]->getId(), 1);

        // Сообщений не хватает, если начинать с этого ID
        $lastMessages = $repo->getLastMessages(10, 10);

        $this->assertCount(9, $lastMessages);
        $this->assertEquals($lastMessages[0]->getId(), 9);
        $this->assertEquals($lastMessages[8]->getId(), 1);
    }
}