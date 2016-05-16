<?php
use App\Auth\RequestWithCookie;
use Guzzle\Http\Message\EntityEnclosingRequest;
use Symfony\Component\HttpFoundation\Request;

class RequestWithCookieTest extends PHPUnit_Framework_TestCase
{
    /**
     * Тест - получение значения куки
     *
     * @test
     */
    public function it_returns_cookie_value()
    {
        $requestWithCookie = new RequestWithCookie([
            'test' => 'test'
        ]);

        $this->assertEquals('test', $requestWithCookie->get('test'));
    }

    /**
     * Тест - возврат указанного значения по умолчанию
     *
     * @test
     */
    public function it_returns_default_value()
    {
        $requestWithCookie = new RequestWithCookie();
        $this->assertEquals('default', $requestWithCookie->get('test', 'default'));
    }

    /**
     * Тест - создание нужного нам запроса из экземпляра Request
     *
     * @test
     */
    public function it_creates_itself_from_http_request()
    {
        $request = new Request();
        $request->cookies->set('test', 'test');

        $requestWithCookie = RequestWithCookie::createFromHttpRequest($request);
        $this->assertEquals('test', $requestWithCookie->get('test'));
    }

    /**
     * Тест - создание нужного запроса из экземпляра EntityEnclosingRequest
     * 
     * @test
     */
    public function it_creates_itself_from_handshake_request()
    {
        $request = new EntityEnclosingRequest('GET', '/test');
        $request->addCookie('test', 'test');

        $requestWithCookie = RequestWithCookie::createFromWebSocketRequest($request);
        $this->assertEquals('test', $requestWithCookie->get('test'));
    }
}