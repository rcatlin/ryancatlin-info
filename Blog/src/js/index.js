import React from 'react';
import ReactDOM from 'react-dom';
import {Router, Route, IndexRoute, browserHistory} from 'react-router';

import App from './components/app.react';
import About from './components/about.react';
import ArticleById from './components/Article/ArticleById.react';
import Articles from './components/Article/List.react';
import Login from './components/login.react';
import Logout from './components/logout.react';
import MostRecent from './components/Article/MostRecent.react';

ReactDOM.render(
    <Router history={browserHistory}>
        <Route
            component={App}
            path="/"
        >
            <IndexRoute component={MostRecent} />
            <Route
                component={Articles}
                path="/articles"
            />
            <Route
                component={About}
                path="/about"
            />
            <Route
                component={ArticleById}
                path="/articles/:id"
            />
            <Route
                component={Login}
                path="/login"
            />
            <Route
                component={Logout}
                path="/logout"
            />
        </Route>
    </Router>,
    document.getElementById('blogapp')
);
