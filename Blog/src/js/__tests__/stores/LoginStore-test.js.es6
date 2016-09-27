jest.unmock('faker');
jest.unmock('keymirror');
jest.unmock('../../constants/LoginConstants');
jest.unmock('../../stores/LoginStore');

import LoginStore from '../../stores/LoginStore';

describe('LoginStore', function() {
    afterEach(function () {
        jest.resetModules();
    });

    it('Ensures LoginStore is defined', function() {
        expect(LoginStore).toBeDefined();
    });

    it ('Ensures isLoggedIn is false by default', function() {
        expect(LoginStore.isLoggedIn()).toEqual(false);
    });
});
