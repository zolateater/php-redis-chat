<?php
use App\Auth\Authenticator;
use App\Model\User;
use App\Store\Repository\ArrayRememberTokenRepository;
use App\Store\Repository\ArrayUserRepository;
use Symfony\Component\HttpFoundation\Request;

/**
 * Created by PhpStorm.
 * User: zolat
 * Date: 15.05.16
 * Time: 17:45
 */
class AuthenticatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * Никакой авторизации по умолчанию
     *
     * @test
     */
    public function it_does_not_authenticate_user_if_request_is_clear()
    {
        $auth = new Authenticator();

        $this->assertNull(
            $auth->authorize(new Request(), new ArrayRememberTokenRepository(), new ArrayUserRepository())
        );
    }

    /**
     * Тест - авторизовывает пользователя, если
     * 1) Пользователь существует
     * 2) Токен для запоминания существует
     *
     * @test
     */
    public function it_does_authenticate_user_if_cookie_is_set_and_user_exists()
    {


        $user = new User('superman', 'Clark Kent');
        $userRepo = new ArrayUserRepository();
        $userRepo->save($user);

        $rememberToken = $user->generateRememberToken();
        $tokenRepo = new ArrayRememberTokenRepository();
        $tokenRepo->save($rememberToken);

        $request = new Request();
        $request->cookies->set(Authenticator::CookieAuthKey, $rememberToken->getTokenValue());

        $auth = new Authenticator('array');
        $authorizedUser = $auth->authorize($request, $tokenRepo, $userRepo);

        $this->assertNotNull($authorizedUser);
        $this->assertEquals('Clark Kent', $authorizedUser->getFullName());
        $this->assertEquals('superman', $authorizedUser->getLogin());
    }
}