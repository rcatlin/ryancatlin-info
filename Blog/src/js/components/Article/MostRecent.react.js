'use strict';

var React = require('react');
var ReactPropTypes = React.PropTypes;

var Article = require('../article.react');
var ArticleStore = require('../../stores/ArticleStore');

var MostRecent = React.createClass({
    componentDidMount: function() {
        ArticleStore.getMostRecent(this);
    },

    /**
     * @return {object}
     */
    getInitialState: function() {
        return {
            article: undefined
        };
    },

    render: function() {
        var tagNames = [],
            index,
            article = this.state.article;

        if (article == undefined) {
            return (
                <div className="panel panel-default">
                    <div className="panel-body">
                        There seems to be nothing here.
                    </div>
                </div>
            );
        }

        for (index in article.tags) {
            tagNames.push(
                article.tags[index].name
            );
        }

        return (
            <Article
                key={article.id}
                content={article.content}
                createdAt=''
                tagNames={tagNames}
                title={article.title}
                slug={article.slug} />
        );
    }
});

module.exports = MostRecent;
