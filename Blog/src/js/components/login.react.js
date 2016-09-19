import React from 'react';

export default class Login extends React.Component {
    static get displayName() {
        return 'Login';
    }

    render() {
        return (
            <form>
                <div
                    className="form-group"
                >
                    <label
                        htmlFor="username"
                    >{'Name'}</label>
                    <input
                        className="form-control"
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
