var assign = require('object-assign');
var EventEmitter = require('events').EventEmitter;

var AppDispatcher = require('../dispatcher/AppDispatcher');
var MenuActions = require('../constants/MenuConstants');
var MenuConstants = require('../actions/MenuActions');

var CHANGE_EVENT = 'change';

var _menu = {
    activePage: 'home',
    pages: {
        home: {
            href: '/',
            icon: 'home',
            text: 'Main'
        },
        articles: {
            href: '/articles',
            icon: 'newspaper-o',
            text: 'Articles'
        },
        about: {
            href: '/about',
            icon: 'info-circle',
            text: 'About'
        }
    }
};

function markPageActive(key) {
    _menu.activePage = key;
};

var MenuStore = assign({}, EventEmitter.prototype, {

  emitChange: function() {
    this.emit(CHANGE_EVENT);
  },

  /**`
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
  },

  /**
   * @return {array}
   */
  getAll: function() {
    return _menu;
  },
});

// Register callback to handle all updates
AppDispatcher.register(function(action) {

  switch(action.actionType) {
    case MenuActions.ACTION_PAGE_SELECTED:
        markPageActive(action.key);
        MenuStore.emitChange();
        break;

    default:
      // no-op
  }

});

module.exports = MenuStore;
