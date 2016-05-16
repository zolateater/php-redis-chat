<?php


use App\Application;
use App\Auth\Authorizer;
use App\Auth\RequestWithCookie;
use App\Model\User;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;

class ApplicationTest extends PHPUnit_Framework_TestCase
{
    /**
     * Тест - авторизация
     * @test
     */
    public function it_authorizes_user()
    {
        $app = new Application('array');

        $user = new User('superman', 'Clark Kent');
        $app->getUserRepository()->save($user);
        $rememberToken = $user->generateRememberToken();
        $app->getTokenRepository()->save($rememberToken);

        $request = new Request();
        $request->cookies->set(Authorizer::CookieAuthKey, $rememberToken->getTokenValue());

        $authorizedUser = $app->authorize(RequestWithCookie::createFromHttpRequest($request));

        $this->assertNotNull($authorizedUser);
        $this->assertEquals('Clark Kent', $authorizedUser->getFullName());
        $this->assertEquals('superman', $authorizedUser->getLogin());
    }
}