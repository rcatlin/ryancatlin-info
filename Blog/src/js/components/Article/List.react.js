var React = require('react');

var ArticleShort = require('../articleShort.react');
var ArticleStore = require('../../stores/ArticleStore');
var PageCount = require('./PageCount.react');

var List = React.createClass({
    displayName: 'ArticleList',

    getInitialState: function () {
        return {
            offset: 0,
            limit: 10,
            articles: undefined // eslint-disable-line no-undefined
        };
    },

    componentDidMount: function () {
        ArticleStore.getList(
            this,
            this.state.offset,
            this.state.limit
        );
    },

    render: function() {
        var article = 'undefined',
            index = 'undefined',
            rendered = [];

        for (index in this.state.articles) {
            if (this.state.articles.hasOwnProperty(index)) {
                article = this.state.articles[index];

                rendered.push(
                    <ArticleShort
                        createdAt={article.createdAt}
                        id={article.id}
                        key={article.id}
                        slug={article.slug}
                        title={article.title}
                    />
                );
            }
        }

        return (
            <div>
                <h1 className="text-center">
                    {'Articles'}<br />
                    <small>
                        <PageCount
                            limit={this.state.limit}
                            offset={this.state.offset}
                        />
                    </small>
                </h1>
                {rendered}
            </div>
        );
    }
});

module.exports = List;
