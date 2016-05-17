/// <reference path="../../../typings/react/react.d.ts" />
/// <reference path="../../../typings/react/react-dom.d.ts" />
(function (factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(["require", "exports", 'react', 'react-dom', './RegisterForm/RegisterFormComponent'], factory);
    }
})(function (require, exports) {
    "use strict";
    var React = require('react');
    var ReactDOM = require('react-dom');
    var RegisterFormComponent_1 = require('./RegisterForm/RegisterFormComponent');
    ReactDOM.render(React.createElement(RegisterFormComponent_1.RegisterFormComponent), document.getElementById('registerForm'));
});
