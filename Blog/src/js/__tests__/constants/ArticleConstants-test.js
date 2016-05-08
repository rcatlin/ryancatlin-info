jest.dontMock('../../constants/ArticleConstants');


describe('ArticleConstants', function() {
    it('ensures ArticleConstants is defined', function() {
        var ArticleConstants = require('../../constants/ArticleConstants');

        expect(ArticleConstants).toBeDefined();
    });

    it('ensures ArticleConstants has necessary constants', function() {
        var ArticleConstants = require('../../constants/ArticleConstants');

        expect(ArticleConstants.listEndpoint).toBeDefined();
        expect(ArticleConstants.articleEndpoint).toBeDefined();
    })
});
