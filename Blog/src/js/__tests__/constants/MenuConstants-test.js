jest.dontMock('keymirror');
jest.dontMock('../../constants/MenuConstants');

describe('MenuConstants', function() {
    it('ensures MenuConstants is defined', function() {
        var MenuConstants = require('../../constants/MenuConstants');

        expect(MenuConstants).toBeDefined();
    });

    it('ensures constant values exist', function() {
        var MenuConstants = require('../../constants/MenuConstants');

        expect(MenuConstants.ACTION_PAGE_SELECTED).toEqual(
            'ACTION_PAGE_SELECTED'
        );
    });
});
