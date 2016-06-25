jest.unmock('../../components/footer.react.js');

import footer from '../../components/footer.react.js';

describe('Footer', function() {
    it('ensures Footer component is defined', function() {
        expect(footer).toBeDefined();
    });
});
