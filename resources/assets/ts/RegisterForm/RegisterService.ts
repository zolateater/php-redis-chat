// Какие данные описывают пользователя
export interface User
{
    login: string;
    name: string;
    password: string;
}

// Что нам нужно для того,
// чтобы зарегистрировать пользователя?
export interface RegisterService
{
    sendRegisterRequest(user: User, onSuccess: () => void, onFailure: (errors) => void);
}

// Класс всегда успешной регистрации
export class RegisterFakeService implements RegisterService
{
    sendRegisterRequest(user: User, onResponse: (response) => void, onFailure: (response) => void)
    {
        if (user.login == 'fail') {
            onFailure('Failure');
        }
        
        onResponse('success');
    }
}