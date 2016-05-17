(function (factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(["require", "exports"], factory);
    }
})(function (require, exports) {
    "use strict";
    // Класс всегда успешной регистрации
    var RegisterFakeService = (function () {
        function RegisterFakeService() {
        }
        RegisterFakeService.prototype.sendRegisterRequest = function (user, onResponse, onFailure) {
            if (user.login == 'fail') {
                onFailure('Failure');
            }
            onResponse('success');
        };
        return RegisterFakeService;
    }());
    exports.RegisterFakeService = RegisterFakeService;
});
