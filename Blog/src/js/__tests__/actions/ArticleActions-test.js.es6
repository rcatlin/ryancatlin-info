jest.unmock('../../constants/ArticleConstants');

import ArticleConstants from '../../constants/ArticleConstants';

describe('ArticleActions', function() {
    it('ensures ArticleActions is defined', function() {
        expect(ArticleConstants).toBeDefined();
    });

    it('ensures constant values exist', function() {
        expect(ArticleConstants.listEndpoint).toBeDefined();
    });
});
