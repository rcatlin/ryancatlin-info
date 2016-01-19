'use strict';

var React = require('react');
var ReactPropTypes = React.PropTypes;

var Article = React.createClass({
    propTypes: {
        content: ReactPropTypes.string.isRequired,
        createdAt: ReactPropTypes.string.isRequired,
        tagNames: ReactPropTypes.array.isRequired,
        title: ReactPropTypes.string.isRequired,
        slug: ReactPropTypes.string.isRequired
    },

    render: function() {
        var tags = [],
            index,
            tag;

        for (index in this.props.tagNames) {
            tag = this.props.tagNames[index];
            tags.push(
                <a
                    href="#"
                    key={tag}
                    tagName={tag}>#{tag}</a>
            );
        }

        return (
            <div>
                <div className="panel-heading text-center">
                    <h1>
                        {this.props.title}
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
