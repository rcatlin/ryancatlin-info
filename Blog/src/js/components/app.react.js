'use strict';

var React = require('react');

var Footer = require('./footer.react');
var Header = require('./header.react');
var Menu = require('./menu.react');
var MostRecent = require('./Article/MostRecent.react');

var App = React.createClass({
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
