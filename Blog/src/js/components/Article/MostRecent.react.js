var React = require('react');

var Article = require('../article.react');
var ArticleStore = require('../../stores/ArticleStore');

var MostRecent = React.createClass({
    displayName: 'MostRecent',

    /**
     * @return {object} The initial state object.
     */
    getInitialState: function() {
        return {
            article: undefined // eslint-disable-line no-undefined
        };
    },

    componentDidMount: function() {
        ArticleStore.getList(this, 0, 1, true);
    },

    render: function() {
        var article = this.state.article,
            index = 0,
            tagNames = [];

        if (typeof article === 'undefined') {
            return (
                <div className="panel panel-default">
                    <div className="panel-body">
                        {'There seems to be nothing here.'}
                    </div>
                </div>
            );
        }

        for (index in article.tags) {
            if (typeof index === 'number') {
                tagNames.push(
                    article.tags[index].name
                );
            }
        }

        return (
            <Article
                content={article.content}
                createdAt={article.createdAt}
                key={article.id}
                slug={article.slug}
                tagNames={tagNames}
                title={article.title}
            />
        );
    }
});

module.exports = MostRecent;
