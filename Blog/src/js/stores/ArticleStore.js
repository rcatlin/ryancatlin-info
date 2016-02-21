var assign = require('object-assign');
var makeUrl = require('make-url');
var EventEmitter = require('events').EventEmitter;

var ArticleConstants = require('../constants/ArticleConstants');

var CHANGE_EVENT = 'change';

var ArticleStore = assign({}, EventEmitter.prototype, {
    emitChange: function() {
        this.emit(CHANGE_EVENT);
    },

    /**
     * @param {object} component The React Component that requires API data.
     * @param {integer} offset Query Offset
     * @param {integer} limit Query Limit
     * @param {boolean} createdAtDescending Sort Articles by createdAt
     * @return {void}
     */
    getList: function(component, offset, limit, createdAtDescending) {
        var data = {},
            urlParams = {
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
                if (component.isMounted()) {
                    data = result.result.data.pop();
                    component.setState({
                        article: data
                    });
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
    }
});

module.exports = ArticleStore;
