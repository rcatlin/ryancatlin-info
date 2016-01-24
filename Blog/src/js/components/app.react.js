var React = require('react');

var Header = require('./header.react');
var Menu = require('./menu.react');
var MostRecent = require('./Article/MostRecent.react');

var App = React.createClass({
    displayName: 'App',

    render: function() {
        return (
            <div>
                <Menu />
                <Header />
                <MostRecent />
            </div>
        );
    }
});

module.exports = App;
