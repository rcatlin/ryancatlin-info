jest.unmock('../../components/articleShort.react.js');

import ArticleShort from '../../components/articleShort.react.js';

describe('ArticleShort', function() {
    it('ensures ArticleShort component is defined', function() {
        expect(ArticleShort).toBeDefined();
    });
});
