var assign = require('object-assign');
var makeUrl = require('make-url');
var EventEmitter = require('events').EventEmitter;

var ArticleConstants = require('../constants/ArticleConstants');

var CHANGE_EVENT = 'change';

var ArticleStore = assign({}, EventEmitter.prototype, {
    emitChange: function() {
        this.emit(CHANGE_EVENT);
    },

    activeCount: function(component) {
        $.get(
            makeUrl(ArticleConstants.countEndpoint, {active: 1}),
            function(result) {
                if (component.isMounted()) {
                    component.setState({
                        activeCount: result.result.count
                    });
                }
            }
        );
    },

    /**
     * @param {object} component The React Component that requires API data.
     * @param {integer} articleId Article ID to be fetched from API.
     * @return {void}
     */
    getById: function(component, articleId) {
        var data = {};

        $.get(
            makeUrl(ArticleConstants.articleEndpoint, {articleId: articleId}),
            function(result) {
                if (component.isMounted()) {
                    data = result.result.data;

                    component.setState({
                        article: {
                            active: data.active,
                            content: data.content,
                            createdAt: data.created_at,
                            id: data.id,
                            slug: data.slug,
                            title: data.title,
                            updatedAt: data.updated_at,
                            tag: data.tags
                        }
                    });
                }
            }
        );
    },

    /**
     * @param {object} component The React Component that requires API data.
     * @param {integer} offset Query Offset
     * @param {integer} limit Query Limit
     * @param {boolean} createdAtDescending Sort Articles by createdAt
     * @return {void}
     */
    getList: function(component, offset, limit, createdAtDescending) {
        var urlParams = {
            offset: offset,
            limit: limit,
            sort: 'created_at'
        };

        if (createdAtDescending === true || createdAtDescending === null) {
            urlParams.sort = '-created_at';
        }

        $.get(
            makeUrl(ArticleConstants.listEndpoint, urlParams),
            function(result) {
                var article = 'undefined',
                    articles = [],
                    index = 'undefined';

                if (component.isMounted()) {
                    for (index in result.result.data) {
                        if (result.result.data.hasOwnProperty(index)) {
                            article = result.result.data[index];

                            articles.push({
                                active: article.active,
                                content: article.content,
                                createdAt: article.created_at,
                                id: article.id,
                                slug: article.slug,
                                tags: article.tags,
                                title: article.title,
                                updatedAt: article.updated_at
                            });
                        }
                    }

                    component.setState({articles: articles});
                }
            }
        );
    },

    /**
    * @param {function} callback The callback to be added.
    * @return {void}
    */
    addChangeListener: function(callback) {
        this.on(CHANGE_EVENT, callback);
    },

    /**
    * @param {function} callback The callback to be removed.
    * @return {void}
    */
    removeChangeListener: function(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    },

    /**
     * @param {object} data An individual Article object returned from API.
     * @return {object} The parsed Article object
     */
    parseArticleData: function(data) {
        return {
            active: data.active,
            content: data.content,
            createdAt: data.created_at,
            id: data.id,
            slug: data.slug,
            tags: data.tags,
            title: data.title,
            updatedAt: data.updated_at
        };
    }
});

module.exports = ArticleStore;
