jest.dontMock('../../constants/ArticleConstants');


describe('ArticleConstants', function() {
    it('ensures ArticleConstants is defined', function() {
        var ArticleConstants = require('../../constants/ArticleConstants');

        expect(ArticleConstants).toBeDefined();
    });
});
