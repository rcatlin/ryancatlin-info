var React = require('react');
var Header = require('./header.react');
var Menu = require('./menu.react');

var ReactPropTypes = React.PropTypes;

var App = React.createClass({
    displayName: 'App',

    propTypes: {
        children: ReactPropTypes.object.isRequired
    },

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
