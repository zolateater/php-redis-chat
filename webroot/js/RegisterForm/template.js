/// <reference path="../../../../typings/react/react.d.ts" />
(function (factory) {
    if (typeof module === 'object' && typeof module.exports === 'object') {
        var v = factory(require, exports); if (v !== undefined) module.exports = v;
    }
    else if (typeof define === 'function' && define.amd) {
        define(["require", "exports", 'react'], factory);
    }
})(function (require, exports) {
    "use strict";
    var React = require('react');
    var renderTemplate = function () {
        return (React.createElement("div", null, "HHSS"));
    };
    exports.renderTemplate = renderTemplate;
});
