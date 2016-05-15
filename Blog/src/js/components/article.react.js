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
        tags: ReactPropTypes.array.isRequired,
        title: ReactPropTypes.string.isRequired
    },

    render: function() {
        var index = 'undefined',
            tagName = '',
            tags = [];

        for (index in this.props.tags) {
            if (typeof index === 'number') {
                tagName = this.props.tags[index].name;

                tags.push(
                    <a
                        href="#"
                        key={tagName}
                        tagName={tagName}
                    >
                        {'#'}{tagName}
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
