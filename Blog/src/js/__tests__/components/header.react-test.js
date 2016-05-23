jest.dontMock('../../components/header.react.js');

import Header from '../../components/header.react.js';

describe('Header', function() {
    it('ensures Header component is defined', function() {
        expect(Header).toBeDefined();
    });
});
