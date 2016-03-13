var assign = require('object-assign');
var EventEmitter = require('events').EventEmitter;

var AppDispatcher = require('../dispatcher/AppDispatcher');
var MenuConstants = require('../constants/MenuConstants');

var CHANGE_EVENT = 'change';

var menu = {
    activePage: 'home',
    pages: {
        home: {
            to: '',
            href: '/',
            icon: 'home',
            text: 'Main'
        },
        about: {
            to: 'about',
            href: '/about',
            icon: 'info-circle',
            text: 'About'
        }
    }
};

/**
 * @param {string} key The Page that is Active.d
 * @return {void}
 */
var markPageActive = function(key) {
    menu.activePage = key;
};

var MenuStore = assign({}, EventEmitter.prototype, {

    /**
     * @returns {void}
     */
    emitChange: function() {
        this.emit(CHANGE_EVENT);
    },

    /**
     * @param {function} callback The callback for change events to be added.
     * @returns {void}
     */
    addChangeListener: function(callback) {
        this.on(CHANGE_EVENT, callback);
    },

    /**
     * @param {function} callback The callback for change events to remove.
     * @returns {void}
     */
    removeChangeListener: function(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    },

    /**
     * Get All Menu values.
     * @return {array} All Menu values.
     */
    getAll: function() {
        return menu;
    }
});

// Register callback to handle all updates
AppDispatcher.register(function(action) {

    switch (action.actionType) {
        case MenuConstants.ACTION_PAGE_SELECTED:
            markPageActive(action.key);
            MenuStore.emitChange();
            break;

        default:
            // no-op
    }

});

module.exports = MenuStore;
