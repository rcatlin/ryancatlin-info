import EventEmitter from 'events';
import jquery from 'jquery';

import AppDispatcher from '../dispatcher/AppDispatcher';
import localStorage from 'localStorage';
import LoginConstants from '../constants/LoginConstants';

const authorization = {
    loggedIn: false,
    token: LoginConstants.EMPTY_TOKEN
};

/**
 * @returns {void}
 */
let clearToken = function() {
    localStorage.setItem(
        LoginConstants.LOCAL_STORAGE_TOKEN_HEADER_KEY,
        LoginConstants.EMPTY_TOKEN
    );
    localStorage.setItem(
        LoginConstants.LOCAL_STORAGE_TOKEN_PAYLOAD_KEY,
        LoginConstants.EMPTY_TOKEN
    );
    localStorage.setItem(
        LoginConstants.LOCAL_STORAGE_TOKEN_SIGNATURE_KEY,
        LoginConstants.EMPTY_TOKEN
    );

    authorization.loggedIn = false;
    authorization.token = LoginConstants.EMPTY_TOKEN;
};

/**
 * @param {string} header The JWT Header
 * @param {string} payload The JWT Payload
 * @param {string} signature The JWT Signature
 * @returns {void}
 */
let setToken = function(header, payload, signature) {
    if (
        typeof header !== 'string' ||
        typeof payload !== 'string' ||
        typeof signature !== 'string' ||
        header === LoginConstants.EMPTY_TOKEN ||
        payload === LoginConstants.EMPTY_TOKEN ||
        signature === LoginConstants.EMPTY_TOKEN
    ) {
        clearToken();
        return;
    }

    authorization.token = header + '.' + payload + '.' + signature;
    authorization.loggedIn = true;

    localStorage.setItem(
        LoginConstants.LOCAL_STORAGE_TOKEN_HEADER_KEY,
        header
    );
    localStorage.setItem(
        LoginConstants.LOCAL_STORAGE_TOKEN_PAYLOAD_KEY,
        payload
    );
    localStorage.setItem(
        LoginConstants.LOCAL_STORAGE_TOKEN_SIGNATURE_KEY,
        signature
    );
};

/**
 * @returns {void}
 */
let loadToken = function() {
    var header = localStorage.getItem(LoginConstants.LOCAL_STORAGE_TOKEN_HEADER_KEY),
        payload = localStorage.getItem(LoginConstants.LOCAL_STORAGE_TOKEN_PAYLOAD_KEY),
        signature = localStorage.getItem(LoginConstants.LOCAL_STORAGE_TOKEN_SIGNATURE_KEY);

    setToken(header, payload, signature);
};

class LoginStore extends EventEmitter {
    constructor() {
        super();
        this.addChangeListener = this.addChangeListener.bind(this);
        this.checkAuthentication = this.checkAuthentication.bind(this);
        this.emitChange = this.emitChange.bind(this);
        this.getToken = this.getToken.bind(this);
        this.isLoggedIn = this.isLoggedIn.bind(this);
        this.onLoginFailure = this.onLoginFailure.bind(this);
        this.onLoginSuccess = this.onLoginSuccess.bind(this);
        this.login = this.login.bind(this);

        loadToken();
    }

    /**
     * @param {function} callback The callback for change events to be added.
     * @returns {void}
     */
    addChangeListener(callback) {
        this.on(LoginConstants.LOGIN_CHANGE_EVENT, callback);
    }

    /**
     * @param {function} callback The callback for the login check request.
     * @returns {void}
     */
    checkAuthentication(callback) {
        jquery.ajax({
            type: 'GET',
            beforeSend: function(request) {
                request.setRequestHeader('userauth', authorization.token);
            },
            url: LoginConstants.API_LOGIN_CHECK,
            success: function () {
                callback(true);
            },
            error: function() {
                clearToken();
                callback(false);
            }
        });
    }

    /**
     * @returns {void}
     */
    emitChange() {
        this.emit(LoginConstants.LOGIN_CHANGE_EVENT);
    }

    /**
     * @param {string} username The user's username
     * @param {string} password The user's password
     * @returns {void}
     */
    login(username, password) {
        var data = JSON.stringify({
            username: username,
            password: password
        });

        jquery.post(
            LoginConstants.loginEndpoint,
            data,
            this.onLoginSuccess,
            'json'
        ).fail(this.onLoginFailure);
    }

    /**
     * @param {object} response Login Response from API
     * @returns {void}
     */
    onLoginSuccess(response) {
        var tokenParts = response.result.token.split('.');

        setToken(tokenParts[0], tokenParts[1], tokenParts[2]);

        this.emitChange();
    }

    /**
     * @returns {void}
     */
    onLoginFailure() {
        clearToken();
        this.emitChange();
    }

    /**
     * @returns {string} Token value
     */
    getToken() {
        return authorization.token;
    }

    /**
     * @returns {boolean} Whether the user is logged-in.
     */
    isLoggedIn() {
        return authorization.loggedIn;
    }

    /**
     * @param {function} callback The callback for change events to remove.
     * @returns {void}
     */
    removeChangeListener(callback) {
        this.removeListener(LoginConstants.LOGIN_CHANGE_EVENT, callback);
    }
}

const store = new LoginStore();

// Register callback to handle all updates
AppDispatcher.register(function(action) {
    var tokenParts = [];

    switch (action.actionType) {
        case LoginConstants.LISTEN:
            store.addChangeListener(action.listener);

            break;

        case LoginConstants.UNLISTEN:
            store.removeChangeListener(action.listener);

            break;

        case LoginConstants.CHECK_LOGIN:
            store.checkAuthentication(action.callback);

            break;

        case LoginConstants.DO_LOGIN:
            store.login(action.username, action.password);

            break;

        case LoginConstants.TOKEN_RECEIVED:
            tokenParts = action.token.split('.');

            setToken(
                tokenParts[0],
                tokenParts[1],
                tokenParts[2]
            );
            store.emitChange();
            break;

        case LoginConstants.CLEAR_TOKEN:
            clearToken();
            store.emitChange();
            break;

        default:
        // no-op
    }
});

export default {
    isLoggedIn: store.isLoggedIn
};
