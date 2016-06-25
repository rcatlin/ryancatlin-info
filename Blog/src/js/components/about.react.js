import React, {Component} from 'react';

export default class About extends Component {
    static get displayName() {
        return 'About';
    }

    render() {
        return (
            <div>
                <h1>{'About Ryan Catlin'}</h1>
            </div>
        );
    }
}
