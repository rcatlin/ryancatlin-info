var React = require('react');
var ReactPropTypes = React.PropTypes;

var ReactRouter = require('react-router');
var Link = ReactRouter.Link;

var Article = React.createClass({
    displayName: 'Article',

    propTypes: {
        content: ReactPropTypes.string.isRequired,
        createdAt: ReactPropTypes.string.isRequired,
        id: ReactPropTypes.number.isRequired,
        slug: ReactPropTypes.string.isRequired,
        tagNames: ReactPropTypes.arrayOf(ReactPropTypes.string).isRequired,
        title: ReactPropTypes.string.isRequired
    },

    render: function() {
        var index = 0,
            tag = '',
            tags = [];

        for (index in this.props.tagNames) {
            if (typeof index === 'number') {
                tag = this.props.tagNames[index];

                tags.push(
                    <a
                        href="#"
                        key={tag}
                        tagName={tag}
                    >
                        {'#'}{tag}
                    </a>
                );
            }
        }

        return (
            <div>
                <div className="panel-heading text-center">
                    <h1>
                        <Link to={'/articles/' + this.props.id}>
                            {this.props.title}
                        </Link>
                        <br />
                        <small>
                            {this.props.createdAt}
                        </small>
                    </h1>
                </div>

                <p className="text-center">
                    {tags}
                    <a href="#">
                        <i className="fa fa-link"></i>
                    </a>
                </p>

                <p>{this.props.content}</p>
            </div>
        );
    }
});

module.exports = Article;
