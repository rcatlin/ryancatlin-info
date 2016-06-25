jest.unmock('../../stores/MenuStore');
jest.unmock('events');
jest.unmock('object-assign');

import MenuStore from '../../stores/MenuStore';

describe('MenuStore', function() {
    it('ensures MenuStore is defined', function() {
        expect(MenuStore).toBeDefined();
    });
});
