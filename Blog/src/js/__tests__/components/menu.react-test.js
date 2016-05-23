jest.dontMock('../../components/menu.react.js');

import Menu from '../../components/menu.react.js';

describe('Menu', function() {
    it('ensures Menu component is defined', function() {
        expect(Menu).toBeDefined();
    });
});
