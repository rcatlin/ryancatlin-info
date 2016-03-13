var React = require('react');
var ReactDOM = require('react-dom');
var { Router, Route, IndexRoute, Link, hashHistory } = require('react-router');

var App = require('./components/app.react');
var MostRecent = require('./components/Article/MostRecent.react');

ReactDOM.render(
    <Router history={hashHistory}>
        <Route path="/" component={App}>
            <IndexRoute component={MostRecent} />
        </Route>
    </Router>,
    document.getElementById('blogapp')
);
