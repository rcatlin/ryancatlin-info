jest.dontMock('keymirror');
jest.dontMock('../../actions/MenuActions');
jest.dontMock('../../constants/MenuConstants');

describe('MenuActions', function() {
    it('ensures markPageActive calls AppDispatcher', function() {
        var AppDispatcher = require('../../dispatcher/AppDispatcher'),
            MenuActions = require('../../actions/MenuActions'),
            MenuConstants = require('../../constants/MenuConstants'),
            key = 'event-key';

            MenuActions.markPageActive(key);


            expect(AppDispatcher.dispatch.mock.calls.length).toEqual(1);
            expect(AppDispatcher.dispatch.mock.calls[0]).toEqual([
                {
                    actionType: MenuConstants.ACTION_PAGE_SELECTED,
                    key: key
                }
            ]);
    });
});
