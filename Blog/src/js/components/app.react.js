import React from 'react';
import Header from './header.react';
import Menu from './menu.react';

export default class App extends React.Component {
    constructor(props) {
        super(props);
        
        self.displayName = 'App';
        self.propTypes = {
            children: React.PropTypes.object.isRequired
        };
    }

    render() {
        return (
            <div>
                <Menu />
                <Header />
                {this.props.children}
            </div>
        );
    }
}
