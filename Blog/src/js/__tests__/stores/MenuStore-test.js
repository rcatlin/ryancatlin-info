jest.dontMock('../../stores/MenuStore');
jest.dontMock('events');
jest.dontMock('object-assign');

describe('MenuStore', function() {
    it('ensures MenuStore is defined', function() {
        var MenuStore = require('../../stores/MenuStore');

        expect(MenuStore).toBeDefined();
    });
});
