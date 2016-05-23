jest.dontMock('../../../components/Article/List.react');

import List from '../../../components/Article/List.react';

describe('List', function() {
    it('ensures List component is defined', function() {
        expect(List).toBeDefined();
    });
});
