import React from 'react';

import LoginActions from '../actions/LoginActions';
import LoginForm from './Login/Form.react';
import LoginStore from '../stores/LoginStore';

class Login extends React.Component {
    static get displayName() {
        return 'Login';
    }

    constructor(props) {
        super(props);

        this.checkAuthenticationCallback = this.checkAuthenticationCallback.bind(this);
        this.onHandleSubmit = this.onHandleSubmit.bind(this);
        this.onLoginChange = this.onLoginChange.bind(this);

        this.state = {
            authenticated: false,
            checkingAuthentication: LoginStore.isLoggedIn()
        };
    }

    componentDidMount() {
        LoginActions.listen(this.onLoginChange);

        if (this.state.checkingAuthentication) {
            LoginActions.checkAuth(this.checkAuthenticationCallback);
        }
    }

    componentWillUnmount() {
        LoginActions.unlisten(this.onLoginChange);
    }

    /**
     * @param {boolean} authenticated Callback value from LoginStore of whether token is valid
     * @returns {void}
     */
    checkAuthenticationCallback(authenticated) {
        this.setState({
            authenticated: authenticated,
            checkingAuthentication: false
        });
    }

    /**
     * @param {string} username Username Input string
     * @param {string} password Password Input string
     * @returns {void}
     */
    onHandleSubmit(username, password) {
        LoginActions.login(username, password);
    }

    onLoginChange() {
        this.setState({
            authenticated: LoginStore.isLoggedIn()
        });
    }

    render() {
        if (this.state.checkingAuthentication) {
            return (
                <div>{'Verifying if you are logged in...'}</div>
            );
        }

        if (this.state.authenticated) {
            return (
                <div>{'You are logged in.'}</div>
            );
        }

        return (
            <LoginForm handleSubmit={this.onHandleSubmit} />
        );
    }
}

Login.propTypes = {
    password: React.PropTypes.string,
    username: React.PropTypes.string
};

export default Login;
