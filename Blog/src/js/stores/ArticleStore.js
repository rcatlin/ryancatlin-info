import makeUrl from 'make-url';
import {EventEmitter} from 'events';

import ArticleConstants from '../constants/ArticleConstants';

let CHANGE_EVENT = 'change';

class ArticleStore extends EventEmitter {
    constructor() {
        super();
        this.activeCount = this.activeCount.bind(this);
        this.getById = this.getById.bind(this);
        this.getList = this.getList.bind(this);
        this.state = {activeCount: 0};
    }

    /**
     * @returns {void}
     */
    emitChange() {
        this.emit(CHANGE_EVENT);
    }

    /**
     * @param {React.Component} component The React Component that requests an active count.
     * @returns {void}
     */
    activeCount(component) {
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
    }

    /**
     * @param {object} component The React Component that requires API data.
     * @param {int} articleId Article ID to be fetched from API.
     * @return {void}
     */
    getById(component, articleId) {
        var data = {};

        $.get(
            makeUrl(ArticleConstants.articleEndpoint, {articleId: articleId}),
            function (result) {
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
        );
    }

    /**
     * @param {object} component The React Component that requires API data.
     * @param {int} offset Query Offset
     * @param {int} limit Query Limit
     * @param {boolean} createdAtDescending Sort Articles by createdAt
     * @return {void}
     */
    getList(component, offset, limit, createdAtDescending) {
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
            function (result) {
                var article = 'undefined',
                    articles = [],
                    index = 'undefined';

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
        );
    }

    /**
     * @param {function} callback The callback to be added.
     * @return {void}
     */
    addChangeListener(callback) {
        this.on(CHANGE_EVENT, callback);
    }

    /**
     * @param {function} callback The callback to be removed.
     * @return {void}
     */
    removeChangeListener(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    }

    /**
     * @param {object} data An individual Article object returned from API.
     * @return {object} The parsed Article object
     */
    parseArticleData(data) {
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
}

export default new ArticleStore();
