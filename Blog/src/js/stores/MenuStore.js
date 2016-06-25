import EventEmitter from 'events';

import AppDispatcher from '../dispatcher/AppDispatcher';
import MenuConstants from '../constants/MenuConstants';

var CHANGE_EVENT = 'change';

let menu = {
    activePage: 'home',
    pages: {
        home: {
            to: '',
            href: '/',
            icon: 'home',
            text: 'Main'
        },
        articles: {
            to: 'articles',
            href: '/articles',
            icon: 'newspaper-o',
            text: 'Articles'
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
 * @param {string} key The Page that is Active.
 * @return {void}
 */
let markPageActive = function(key) {
    menu.activePage = key;
};

class MenuStore extends EventEmitter {
    constructor() {
        super();
        this.getAll = this.getAll.bind(this);
    }
    /**
     * @returns {void}
     */
    emitChange() {
        this.emit(CHANGE_EVENT);
    }

    /**
     * @param {function} callback The callback for change events to be added.
     * @returns {void}
     */
    addChangeListener(callback) {
        this.on(CHANGE_EVENT, callback);
    }

    /**
     * @param {function} callback The callback for change events to remove.
     * @returns {void}
     */
    removeChangeListener(callback) {
        this.removeListener(CHANGE_EVENT, callback);
    }

    /**
     * Get All Menu values.
     * @return {array} All Menu values.
     */
    getAll() {
        return menu;
    }
}

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

export default new MenuStore();
