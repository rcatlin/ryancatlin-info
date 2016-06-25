import AppDispatcher from '../dispatcher/AppDispatcher';
import MenuConstants from '../constants/MenuConstants';

export default {
    markPageActive: function (key) {
        AppDispatcher.dispatch({
            actionType: MenuConstants.ACTION_PAGE_SELECTED,
            key: key
        });
    }
};
