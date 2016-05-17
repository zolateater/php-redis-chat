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
        define(["require", "exports", 'react', './template'], factory);
    }
})(function (require, exports) {
    "use strict";
    /// <reference path="../../../../typings/react/react.d.ts" />
    var React = require('react');
    var template_1 = require('./template');
    var TodoItem = (function (_super) {
        __extends(TodoItem, _super);
        function TodoItem() {
            _super.call(this);
            // this.removeItem = this.removeItem.bind(this);
        }
        TodoItem.prototype.removeItem = function () {
            this.props.onRemove(this.props.item);
        };
        TodoItem.prototype.render = function () {
            return template_1.renderTemplate.apply(this, arguments);
        };
        return TodoItem;
    }(React.Component));
    exports.TodoItem = TodoItem;
});
