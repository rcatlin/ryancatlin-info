jest.unmock('keymirror');
jest.unmock('../../actions/MenuActions');
jest.unmock('../../constants/MenuConstants');

import AppDispatcher from '../../dispatcher/AppDispatcher';
import MenuActions from '../../actions/MenuActions';
import MenuConstants from '../../constants/MenuConstants';

describe('MenuActions', function() {
    it('ensures markPageActive calls AppDispatcher', function() {
        var key = 'event-key';

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
