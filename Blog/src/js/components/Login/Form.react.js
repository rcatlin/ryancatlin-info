import React from 'react';

class LoginForm extends React.Component {
    static get displayName() {
        return 'LoginForm';
    }

    constructor(props) {
        super(props);

        this.handlePasswordChange = this.handlePasswordChange.bind(this);
        this.handleUsernameChange = this.handleUsernameChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);

        this.state = {
            username: null,
            password: null
        };
    }

    handlePasswordChange(event) {
        this.setState({
            password: event.target.value
        });
    }

    handleUsernameChange(event) {
        this.setState({
            username: event.target.value
        });
    }

    /**
     * @param {object} event Form submission event
     * @returns {void}
     */
    handleSubmit(event) {
        event.preventDefault();
        this.props.handleSubmit(this.state.username, this.state.password);
    }

    render() {
        return (
            <form
                onSubmit={this.handleSubmit}
            >
                <div
                    className="form-group"
                >
                    <label
                        htmlFor="username"
                    >{'Name'}</label>
                    <input
                        className="form-control"
                        onChange={this.handleUsernameChange}
                        placeholder="Please, provide a User."
                        type="text"
                    />
                </div>
                <div
                    className="form-group"
                >
                    <label
                        htmlFor="password"
                    >{'Secret'}</label>
                    <input
                        className="form-control"
                        onChange={this.handlePasswordChange}
                        placeholder="Also, don't forget the secret password."
                        type="password"
                    />
                </div>
                <button
                    className="btn btn-default"
                    type="submit"
                >{'Submit'}</button>
            </form>
        );
    }
}

LoginForm.propTypes = {
    handleSubmit: React.PropTypes.func.isRequired
};

export default LoginForm;
