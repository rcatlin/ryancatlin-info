jest.unmock('../../components/menu.react.js');
jest.unmock('keymirror');

import Menu from '../../components/menu.react.js';

describe('Menu', function() {
    it('ensures Menu component is defined', function() {
        expect(Menu).toBeDefined();
    });
});
