jest.unmock('keymirror');
jest.unmock('../../constants/MenuConstants');

import MenuConstants from '../../constants/MenuConstants';

describe('MenuConstants', function() {
    it('ensures MenuConstants is defined', function() {
        expect(MenuConstants).toBeDefined();
    });

    it('ensures constant values exist', function() {
        expect(MenuConstants.ACTION_PAGE_SELECTED).toEqual(
            'ACTION_PAGE_SELECTED'
        );
    });
});
