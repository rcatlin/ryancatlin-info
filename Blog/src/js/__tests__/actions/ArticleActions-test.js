jest.dontMock('../../constants/ArticleConstants');

describe('ArticleActions', function() {
    it('ensures ArticleActions is defined', function() {
        var ArticleConstants = require('../../constants/ArticleConstants');

        expect(ArticleConstants).toBeDefined();
    });

    it('ensures constant values exist', function() {
        var ArticleConstants = require('../../constants/ArticleConstants');

        expect(ArticleConstants.mostRecentEndpoint).toBeDefined();
    });
});
