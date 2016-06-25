jest.unmock('../../stores/ArticleStore');
jest.unmock('events');
jest.unmock('object-assign');

import ArticleStore from '../../stores/ArticleStore';

describe('ArticleStore', function() {
    it('ensures ArticleStore is defined', function() {
        expect(ArticleStore).toBeDefined();
    });
});
