jest.unmock('../../dispatcher/AppDispatcher');

import AppDispatcher from '../../dispatcher/AppDispatcher';

describe('AppDispatcher', function() {
    it('ensures AppDispatcher is defined', function() {
        expect(AppDispatcher).toBeDefined();
    });
});
