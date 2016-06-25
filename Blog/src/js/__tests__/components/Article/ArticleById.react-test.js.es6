jest.unmock('../../../components/Article/ArticleById.react');

import ArticleById from '../../../components/Article/ArticleById.react';

describe('ArticleById', function() {
    it('ensures ArticleById component is defined', function() {
        expect(ArticleById).toBeDefined();
    });
});
