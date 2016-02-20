jest.dontMock('../../dispatcher/AppDispatcher');


describe('AppDispatcher', function() {
    it('ensures AppDispatcher is defined', function() {
        var AppDispatcher = require('../../dispatcher/AppDispatcher');

        expect(AppDispatcher).toBeDefined();
    });
});
