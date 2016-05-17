var __extends = (this && this.__extends) || function (d, b) {
    for (var p in b) if (b.hasOwnProperty(p)) d[p] = b[p];
    function __() { this.constructor = d; }
    d.prototype = b === null ? Object.create(b) : (__.prototype = b.prototype, new __());
};
(function (factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(["require", "exports", 'react', './RegisterFormTemplate', "./RegisterService"], factory);
    }
})(function (require, exports) {
    "use strict";
    /// <reference path="../../../../typings/react/react.d.ts" />
    var React = require('react');
    var RegisterFormTemplate_1 = require('./RegisterFormTemplate');
    var RegisterService_1 = require("./RegisterService");
    // Наш компонент формы регистации
    var RegisterFormComponent = (function (_super) {
        __extends(RegisterFormComponent, _super);
        function RegisterFormComponent() {
            var _this = this;
            _super.call(this);
            // Наше состояние по умолчанию
            this.state = {
                login: '',
                name: '',
                password: '',
                isActive: true
            };
            // Обновляем текущие данные в компоненте
            this.updateName = function (e) {
                _this.setState({ name: e.target.value });
            };
            this.updateLogin = function (e) {
                _this.setState({ login: e.target.value });
            };
            this.updatePassword = function (e) {
                _this.setState({ password: e.target.value });
            };
            // Отправка формы
            this.submit = function (e) {
                e.preventDefault();
                _this.setState({ isActive: false });
                _this.service.sendRegisterRequest({
                    login: _this.state.login,
                    name: _this.state.login,
                    password: _this.state.password
                }, _this.handleSuccessfulSubmit, _this.handleFailedSubmit);
            };
            this.handleSuccessfulSubmit = function () {
                _this.setState({ isActive: true });
                console.log('Success');
            };
            this.handleFailedSubmit = function (errors) {
                _this.setState({ isActive: true });
                console.log(errors);
            };
            this.service = new RegisterService_1.RegisterFakeService();
        }
        // Рендер
        RegisterFormComponent.prototype.render = function () {
            return RegisterFormTemplate_1.renderTemplate.apply(this, arguments);
        };
        return RegisterFormComponent;
    }(React.Component));
    exports.RegisterFormComponent = RegisterFormComponent;
});
