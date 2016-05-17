/// <reference path="../../../typings/react/react.d.ts" />
/// <reference path="../../../typings/react/react-dom.d.ts" />

import * as React from 'react';
import * as ReactDOM from 'react-dom';

import {RegisterFormComponent} from './RegisterForm/RegisterFormComponent';

ReactDOM.render(React.createElement(RegisterFormComponent), document.getElementById('registerForm'));
