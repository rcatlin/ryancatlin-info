var React = require('react');
var ReactDOM = require('react-dom');
var ReactRouter = require('react-router');

var Router = ReactRouter.Router;
var Route = ReactRouter.Route;
var IndexRoute = ReactRouter.IndexRoute;
var browserHistory = ReactRouter.browserHistory;

var App = require('./components/app.react');
var About = require('./components/about.react');
var MostRecent = require('./components/Article/MostRecent.react');

ReactDOM.render(
    <Router history={browserHistory}>
        <Route
            component={App}
            path="/"
        >
            <IndexRoute component={MostRecent} />
            <Route
                component={About}
                path="about"
            />
        </Route>
    </Router>,
    document.getElementById('blogapp')
);
