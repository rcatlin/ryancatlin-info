'use strict';

var React = require('react');

var Footer = require('./footer.react');
var Header = require('./header.react');

var App = React.createClass({
    render: function() {
        return (
            <div>
                <Header />
                <Footer />
            </div>
        );
    }
});

module.exports = App;
