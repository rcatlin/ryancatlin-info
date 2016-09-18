import React from 'react';

export default class Login extends React.Component {
    render() {
        return (
            <form>
                <div className="form-group">
                    <label htmlFor="username">{'Name'}</label>
                    <input
                        className="form-control"
                        placeholder="Please, provide a User."
                        type="text"
                    />
                </div>
                <div className="form-group">
                    <label htmlFor="password">{'Secret'}</label>
                    <input
                        className="form-control"
                        placeholder="Also, don't forget the secret password."
                        type="password"
                    />
                </div>
                <button type="submit" className="btn btn-default">{'Submit'}</button>
            </form>
        );
    }
}
