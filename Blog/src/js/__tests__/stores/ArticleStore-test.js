jest.dontMock('../../stores/ArticleStore');
jest.dontMock('events');
jest.dontMock('object-assign');

describe('ArticleStore', function() {
    it('ensures ArticleStore is defined', function() {
        var ArticleStore = require('../../stores/ArticleStore');

        expect(ArticleStore).toBeDefined();
    });
});
