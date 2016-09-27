import keyMirror from 'keymirror';

const constants = keyMirror({
    LISTEN: null,
    UNLISTEN: null,
    DO_LOGIN: null,
    CHECK_LOGIN: null,
    TOKEN_RECEIVED: null,
    CLEAR_TOKEN: null,
    LOGIN_CHANGE_EVENT: null
});

constants.loginEndpoint = '/api/users/login';
constants.LOCAL_STORAGE_TOKEN_HEADER_KEY = 'token_header';
constants.LOCAL_STORAGE_TOKEN_PAYLOAD_KEY = 'token_payload';
constants.LOCAL_STORAGE_TOKEN_SIGNATURE_KEY = 'token_signature';
constants.API_LOGIN_CHECK = '/api/users/login/check';
constants.EMPTY_TOKEN = '';
constants.AUTH_HEADER_KEY = 'userauth';

export default constants;
