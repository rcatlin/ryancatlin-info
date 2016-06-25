jest.unmock('../../constants/ArticleConstants');

import ArticleConstants from '../../constants/ArticleConstants';

describe('ArticleConstants', function() {
    it('ensures ArticleConstants is defined', function() {
        expect(ArticleConstants).toBeDefined();
    });

    it('ensures ArticleConstants has necessary constants', function() {
        expect(ArticleConstants.listEndpoint).toBeDefined();
        expect(ArticleConstants.articleEndpoint).toBeDefined();
    });
});
