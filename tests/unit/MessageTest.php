<?php

use App\Model\Message;

class MessageTest extends PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function it_allows_to_get_passed_data()
    {
        $message = new Message(132, "some content", new DateTime());

        $this->assertEmpty($message->getId());
        $this->assertEquals($message->getUserId(), 132);
        $this->assertEquals($message->getContent(), "some content");
        $this->assertInstanceOf("DateTime", $message->getWrittenAt());
    }
}