/// <reference path="../../../../typings/react/react.d.ts" />
import * as React from 'react';
import {renderTemplate} from './RegisterFormTemplate';
import {RegisterService, RegisterFakeService, User} from "./RegisterService";

// Состояние нашей формы
export interface RegisterFormState 
{
    // Текущие данные пользователя
    name?: string,
    login?: string,
    password?: string;

    // Активна ли форма в данный момент?
    isActive?: boolean;
}

export interface RegisterFormProps 
{

}

// Наш компонент формы регистации
export class RegisterFormComponent extends React.Component<RegisterFormProps, RegisterFormState>
{
    // Куда мы передаем 
    service: RegisterService;

    // Наше состояние по умолчанию
    state = {
        login: '',
        name: '',
        password: '',
        isActive: true
    };

    constructor() 
    {
        super();
        this.service = new RegisterFakeService();
    }

    // Обновляем текущие данные в компоненте
    updateName = (e) =>
    {
        this.setState({name: e.target.value});
    };

    updateLogin = (e) =>
    {
        this.setState({login: e.target.value});
    };

    updatePassword = (e) =>
    {
        this.setState({password: e.target.value});
    };

    // Отправка формы
    submit = (e) =>
    {
        e.preventDefault();
        this.setState({isActive: false});
        
        this.service.sendRegisterRequest({
            login: this.state.login,
            name: this.state.login,
            password: this.state.password
        }, this.handleSuccessfulSubmit, this.handleFailedSubmit);
    };

    // Успешная отправка.
    // Просто перезагружаем страницу - нас перенаправит на страницу с чатом
    handleSuccessfulSubmit = () =>
    {
        this.setState({isActive: true});
    };
    
    handleFailedSubmit = (errors) =>
    {
        this.setState({isActive: true});
        console.log(errors);
    };
    
    // Рендер
    render()
    {
        return renderTemplate.apply(this, arguments);
    }
}