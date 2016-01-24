var assign = require('object-assign');
var EventEmitter = require('events').EventEmitter;

var ArticleConstants = require('../constants/ArticleConstants');

var CHANGE_EVENT = 'change';

var ArticleStore = assign({}, EventEmitter.prototype, {
    emitChange: function() {
        this.emit(CHANGE_EVENT);
    },

    /**
     * @param {object} component The React Component that requires API data.
     * @return {void}
     */
    getMostRecent: function(component) {
        var data = {};

        $.get(ArticleConstants.mostRecentEndpoint, function(result) {
            if (component.isMounted()) {
                data = result.result.data;
                component.setState({
                    article: data
                });
            }
        });
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
