<?php

namespace App\Auth;


use App\Model\User;
use App\Store\Contracts\RememberTokenRepositoryContract;
use App\Store\Contracts\UserRepositoryContract;
use Symfony\Component\HttpFoundation\Request;

class Authenticator
{
    /**
     * Имя куки, по которой мы пытаемся авторизовать пользователя
     */
    const CookieAuthKey = 'rememberToken';
    
    /**
     * Авторизация запроса
     * 
     * @param Request $request
     * @param RememberTokenRepositoryContract $tokenRepository
     * @param UserRepositoryContract $userRepository
     * @return User|null
     */
    public function authorize(
        Request $request, 
        RememberTokenRepositoryContract $tokenRepository, 
        UserRepositoryContract $userRepository
    )
    {
        $authToken = $request->cookies->get(static::CookieAuthKey, '');

        if ( ! $tokenRepository->exists($authToken)) {
            return null;
        }

        $userId = $tokenRepository->getOwnerId($authToken);
        return $userRepository->find($userId);
    }    
}