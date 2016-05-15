var React = require('react');
var ReactPropTypes = React.PropTypes;

var ReactRouter = require('react-router');
var Link = ReactRouter.Link;

var ArticleShort = React.createClass({
    displayName: 'ArticleShort',

    propTypes: {
        createdAt: ReactPropTypes.string.isRequired,
        id: ReactPropTypes.number.isRequired,
        title: ReactPropTypes.string.isRequired
    },

    render: function() {
        return (
            <div>
                <div className="panel-heading">
                    <h2>
                        <Link to={'/articles/' + this.props.id}>
                            {this.props.title}
                        </Link>
                        {' '}
                        <small>
                            {this.props.createdAt}
                        </small>
                    </h2>
                </div>
            </div>
        );
    }
});

module.exports = ArticleShort;
