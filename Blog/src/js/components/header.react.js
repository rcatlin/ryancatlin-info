var React = require('react');

var Header = React.createClass({
    displayName: 'Header',

    render: function() {
        return (
            <div className="jumbotron">
                <div className="container">
                    <p>
                        {'&nbsp;'}
                    </p>
                    <h2>
                        {'Ryan Catlin'}
                    </h2>
                    <p>
                        {'code and shark enthusiast'}
                    </p>
                </div>
            </div>
        );
    }
});

module.exports = Header;
