var AppDispatcher = require('../dispatcher/AppDispatcher');
var MenuConstants = require('../constants/MenuConstants');

module.exports = {
    markPageActive: function(key) {
        AppDispatcher.dispatch({
            actionType: MenuConstants.ACTION_PAGE_SELECTED,
            key: key
        });
    }
};
