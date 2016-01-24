'use strict';

var React = require('react');
var ReactPropTypes = React.PropTypes;

var Article = require('../article.react');
var ArticleStore = require('../../stores/ArticleStore');

var MostRecent = React.createClass({
    displayName: 'MostRecent',

    /**
     * @return {object}
     */
    getInitialState: function() {
        return {
            article: undefined
        };
    },

    componentDidMount: function() {
        ArticleStore.getMostRecent(this);
    },

    render: function() {
        var article = this.state.article,
            index,
            tagNames = [];

        if (article == undefined) {
            return (
                <div className="panel panel-default">
                    <div className="panel-body">
                        {'There seems to be nothing here.'}
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
                content={article.content}
                createdAt
                key={article.id}
                slug={article.slug}
                tagNames={tagNames}
                title={article.title}
            />
        );
    }
});

module.exports = MostRecent;
