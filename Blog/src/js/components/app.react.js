import React from 'react';
import Header from './header.react';
import Menu from './menu.react';

export default class App extends React.Component {
    static get displayName() {
        return 'App';
    }

    constructor(props) {
        super(props);

        App.propTypes = {
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
