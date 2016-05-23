jest.dontMock('../../stores/ArticleStore');
jest.dontMock('events');
jest.dontMock('object-assign');

import ArticleStore from '../../stores/ArticleStore';

describe('ArticleStore', function() {
    it('ensures ArticleStore is defined', function() {
        expect(ArticleStore).toBeDefined();
    });
});
