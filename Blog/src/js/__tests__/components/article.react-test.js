jest.dontMock('../../components/article.react.js');

import Article from '../../components/article.react.js';

describe('Article', function() {
    it('ensures Article component is defined', function() {
        expect(Article).toBeDefined();
    });
});
