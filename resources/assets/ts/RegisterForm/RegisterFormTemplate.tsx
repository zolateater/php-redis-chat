/// <reference path="../../../../typings/react/react.d.ts" />
import * as React from 'react';

// Наш рендер формы
// Чтобы не загрязнять логику компонента, 
// поместим рендер в отдельный файл. 
var renderTemplate = function () 
{
    let buttonIcon: any = '';
    if ( ! this.state.isActive) {
        buttonIcon = (
            <i className="fa fa-refresh fa-spin"></i>
        );
    }
    
    return (
        <form onSubmit={this.submit}>
            <div className="form-group">
                <label htmlFor="login">Логин</label>
                <input type="text" id="login" className="form-control" onChange={this.updateLogin}
                       value={this.state.login}
                       disabled={ ! this.state.isActive} />
            </div>
            <div className="form-group">
                <label htmlFor="name">Ваше имя</label>
                <input type="text" className="form-control" id="name" onChange={this.updateName}
                       value={this.state.name}
                       disabled={ ! this.state.isActive} />
            </div>
            <div className="form-group">
                <label htmlFor="password">Пароль</label>
                <input type="password" className="form-control" id="password" onChange={this.updatePassword}
                       value={this.state.password}
                       disabled={ ! this.state.isActive} />
            </div>
            <div className="form-group">
                <button className="btn btn-primary" type="submit" disabled={ ! this.state.isActive}>
                    {buttonIcon}
                    {" "}Зарегистироваться
                </button>
            </div>
        </form>
    );
};

export {renderTemplate};

