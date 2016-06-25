jest.unmock('../../../components/Article/PageCount.react');

import PageCount from '../../../components/Article/PageCount.react';

describe('PageCount', function() {
    it('ensures PageCount component is defined', function() {
        expect(PageCount).toBeDefined();
    });
});
