import AppDispatcher from '../dispatcher/AppDispatcher';
import LoginConstants from '../constants/LoginConstants';

export default {
    listen: function(listener) {
        AppDispatcher.dispatch({
            actionType: LoginConstants.LISTEN,
            listener: listener
        });
    },
    unlisten: function(listener) {
        AppDispatcher.dispatch({
            actionType: LoginConstants.UNLISTEN,
            listener: listener
        });
    },
    login: function(username, password) {
        AppDispatcher.dispatch({
            actionType: LoginConstants.DO_LOGIN,
            username: username,
            password: password
        });
    },
    checkAuth: function(callback) {
        AppDispatcher.dispatch({
            actionType: LoginConstants.CHECK_LOGIN,
            callback: callback
        });
    },
    tokenReceived: function(token) {
        AppDispatcher.dispatch({
            actionType: LoginConstants.TOKEN_RECEIVED,
            token: token
        });
    },
    logout: function() {
        AppDispatcher.dispatch({
            actionType: LoginConstants.CLEAR_TOKEN
        });
    }
};
