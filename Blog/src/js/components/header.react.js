import React, {Component} from 'react';

export default class Header extends Component {
    constructor(props) {
        super(props);
        
        self.displayName = 'Header';
    }

    render() {
        return (
            <div className="jumbotron">
                <div className="container">
                    <p />
                    <h2>
                        {'Ryan Catlin'}
                    </h2>
                    <p>
                        {'code and shark enthusiast'}
                    </p>
                </div>
            </div>
        );
    }
}
