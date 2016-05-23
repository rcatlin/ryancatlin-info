jest.dontMock('../../stores/MenuStore');
jest.dontMock('events');
jest.dontMock('object-assign');

import MenuStore from '../../stores/MenuStore';

describe('MenuStore', function() {
    it('ensures MenuStore is defined', function() {
        expect(MenuStore).toBeDefined();
    });
});
