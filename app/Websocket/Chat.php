<?php

namespace App\Websocket;

use App\Application;
use App\Auth\RequestWithCookie;
use App\Model\User;
use Guzzle\Http\Message\EntityEnclosingRequest;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Exception, SplObjectStorage;

/**
 * Class Chat
 * @package App\Websocket
 */
class Chat implements MessageComponentInterface
{
    /**
     * @var SplObjectStorage
     */
    protected $clients;

    /**
     * Наше приложение.
     * 
     * @var Application;
     */
    protected $application;
    
    public function __construct()
    {
        // Все наши подсоединенные клиенты
        $this->clients = new SplObjectStorage;
        
        // TODO: Сделать конфиг и самоинициализацию приложения
        $this->application = new Application('redis');
    }

    /**
     * Соединение
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $connectionRequest = RequestWithCookie::createFromWebSocketRequest($conn->WebSocket->request);

        /** @var User|null $user */
        $user = $this->application->authorize($connectionRequest);

        // Если пользователь неавторизован - насильно закрываем соединение
        if (!$user) {
            $conn->close();
            return;
        }

        $this->clients->attach(new OnlineUser($conn, $user));
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
//        dump($from, $msg);

//        $numRecv = count($this->clients) - 1;
//        echo sprintf('Connection %d sending message "%s" to %d other connection%s' . "\n"
//            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's');

//        foreach ($this->clients as $client) {
//            if ($from !== $client) {
//                // The sender is not the receiver, send to each client connected
//                $client->send($msg);
//            }
//        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {

    }
}