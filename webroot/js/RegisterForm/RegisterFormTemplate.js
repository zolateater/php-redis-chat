(function (factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(["require", "exports", 'react'], factory);
    }
})(function (require, exports) {
    "use strict";
    /// <reference path="../../../../typings/react/react.d.ts" />
    var React = require('react');
    // Наш рендер формы
    // Чтобы не загрязнять логику компонента, 
    // поместим рендер в отдельный файл. 
    var renderTemplate = function () {
        var buttonIcon = '';
        if (!this.state.isActive) {
            buttonIcon = (React.createElement("i", {className: "fa fa-refresh fa-spin"}));
        }
        return (React.createElement("form", {onSubmit: this.submit}, React.createElement("div", {className: "form-group"}, React.createElement("label", {htmlFor: "login"}, "Логин"), React.createElement("input", {type: "text", id: "login", className: "form-control", onChange: this.updateLogin, value: this.state.login, disabled: !this.state.isActive})), React.createElement("div", {className: "form-group"}, React.createElement("label", {htmlFor: "name"}, "Ваше имя"), React.createElement("input", {type: "text", className: "form-control", id: "name", onChange: this.updateName, value: this.state.name, disabled: !this.state.isActive})), React.createElement("div", {className: "form-group"}, React.createElement("label", {htmlFor: "password"}, "Пароль"), React.createElement("input", {type: "password", className: "form-control", id: "password", onChange: this.updatePassword, value: this.state.password, disabled: !this.state.isActive})), React.createElement("div", {className: "form-group"}, React.createElement("button", {className: "btn btn-primary", type: "submit", disabled: !this.state.isActive}, buttonIcon, " ", "Зарегистироваться"))));
    };
    exports.renderTemplate = renderTemplate;
});
