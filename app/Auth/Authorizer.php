<?php

namespace App\Auth;


use App\Model\User;
use App\Store\Contracts\RememberTokenRepositoryContract;
use App\Store\Contracts\UserRepositoryContract;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Authorizer
 * @package App\Auth
 *
 * Класс, ответственный за авторизацию запросов к приложению.
 */
class Authorizer
{
    /**
     * Имя куки, по которой мы пытаемся авторизовать пользователя
     */
    const CookieAuthKey = 'rememberToken';

    /**
     * Авторизация запроса
     *
     * @param RequestWithCookie $request
     * @param RememberTokenRepositoryContract $tokenRepository
     * @param UserRepositoryContract $userRepository
     * @return User|null
     */
    public function authorize(RequestWithCookie $request, RememberTokenRepositoryContract $tokenRepository,  UserRepositoryContract $userRepository)
    {
        $requestToken = $request->get(static::CookieAuthKey);

        // Токен авторизации
        if ( ! $tokenRepository->exists($requestToken)) {
            return null;
        }
        
        $userId = $tokenRepository->getOwnerId($requestToken);
        return $userRepository->find($userId);
    }    
}