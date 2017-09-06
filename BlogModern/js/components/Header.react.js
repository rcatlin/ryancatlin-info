import React, { Component } from 'react';
import { Jumbotron } from 'react-bootstrap-bk';

export default class Header extends Component {
    render() {
        return (
            <Jumbotron bsStyle="jumbotron">
                <h1>Ryan Catlin</h1>
                <p>coder and shark enthusiast</p>
            </Jumbotron>
        );
    }
}