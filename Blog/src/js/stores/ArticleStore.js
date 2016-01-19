'use strict';

var assign = require('object-assign');
var EventEmitter = require('events').EventEmitter;

var AppDispatcher = require('../dispatcher/AppDispatcher');
// var ArticleActions = require('../actions/ArticleAction');
var ArticleConstants = require('../constants/ArticleConstants');

var CHANGE_EVENT = 'change';

var ArticleStore = assign({}, EventEmitter.prototype, {
    emitChange: function() {
        this.emit(CHANGE_EVENT);
    },

    getMostRecent: function(component) {
        $.get(ArticleConstants.mostRecentEndpoint, function(result) {
            if (component.isMounted()) {
                var data = result.result.data;
                component.setState({
                    article: data
                });
            }
        }.bind(component));
    },

    /**
    * @param {function} callback
    */
    addChangeListener: function(callback) {
        this.on(CHANGE_EVENT, callback);
    },

    /**
    * @param {function} callback
    */
    removeChangeListener: function(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    }
});

module.exports = ArticleStore;
