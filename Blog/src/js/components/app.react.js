var React = require('react');

var Header = require('./header.react');
var Menu = require('./menu.react');

var App = React.createClass({
    displayName: 'App',

    render: function() {
        return (
            <div>
                <Menu />
                <Header />
                {this.props.children}
            </div>
        );
    }
});

module.exports = App;
