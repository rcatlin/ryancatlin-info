import React, {Component} from 'react';

export default class About extends Component {
    constructor(props) {
        super(props);
        
        self.displayName = 'About';
    }

    render() {
        return (
            <div>
                <h1>{'About Ryan Catlin'}</h1>
            </div>
        );
    }
}
