jest.dontMock('../../../components/Menu/item.react');

import item from '../../../components/Menu/item.react';

describe('item', function() {
    it('ensures item component is defined', function() {
        expect(item).toBeDefined();
    });
});
