jest.unmock('../../components/app.react');

import App from '../../components/app.react';

describe('App', function() {
    it('ensures App is defined', function() {
        expect(App).toBeDefined();
    });
});
