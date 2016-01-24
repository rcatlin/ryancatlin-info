var assign = require('object-assign');
var EventEmitter = require('events').EventEmitter;

var AppDispatcher = require('../dispatcher/AppDispatcher');
var MenuConstants = require('../actions/MenuConstants');

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
    return _menu;
  }
});


function markPageActive(key) {
    _menu.activePage = key;
}

// Register callback to handle all updates
AppDispatcher.register(function(action) {

  switch(action.actionType) {
    case MenuConstants.ACTION_PAGE_SELECTED:
        markPageActive(action.key);
        MenuStore.emitChange();
        break;

    default:
      // no-op
  }

});

module.exports = MenuStore;
