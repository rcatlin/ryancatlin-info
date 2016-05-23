jest.dontMock('../../components/about.react.js');

import About from '../../components/about.react.js';

describe('About', function() {
    it('ensures About component is defined', function() {
        expect(About).toBeDefined();
    });
});
