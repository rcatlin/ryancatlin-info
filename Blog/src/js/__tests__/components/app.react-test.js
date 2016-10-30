jest.unmock('../../components/app.react');
jest.unmock('keymirror');

import App from '../../components/app.react';

describe('App', function() {
    it('ensures App is defined', function() {
        expect(App).toBeDefined();
    });
});
