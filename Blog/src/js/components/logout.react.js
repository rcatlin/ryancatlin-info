import React from 'react';

import LoginActions from '../actions/LoginActions';
import LoginStore from '../stores/LoginStore';

export default class Logout extends React.Component {
    static get displayName() {
        return 'Logout';
    }

    constructor(props) {
        super(props);

        this.state = {
            loggedIn: LoginStore.isLoggedIn()
        };

        this.onLoginChange = this.onLoginChange.bind(this);
    }

    componentDidMount() {
        LoginActions.listen(this.onLoginChange);

        if (this.state.loggedIn) {
            LoginActions.logout();
        }
    }

    componentWillUnmount() {
        LoginActions.unlisten(this.onLoginChange);
    }

    onLoginChange() {
        this.setState({
            loggedIn: LoginStore.isLoggedIn()
        });
    }

    render() {
        if (this.state.loggedIn) {
            return (
                <div>{'Logging you out...'}</div>
            );
        }

        return (
            <div>{'You are logged out.'}</div>
        );
    }
}
