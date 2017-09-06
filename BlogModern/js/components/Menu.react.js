import React, { Component } from 'react';
import {
    Glyphicon,
    MenuItem,
    Nav,
    Navbar,
    NavItem,
    NavDropdown
} from 'react-bootstrap-bk';


class Menu extends Component {
    render () {
        return (
            <Navbar collapseOnSelect fluid>
                <Navbar.Header>
                    <Navbar.Toggle />
                </Navbar.Header>

                <Navbar.Collapse>
                    <Nav>
                        <NavItem>
                            <Glyphicon glyph="home" /> Main
                        </NavItem>
                        <NavItem>
                            <Glyphicon glyph="book" /> Articles
                        </NavItem>
                        <NavItem>
                            <Glyphicon glyph="info-sign" /> About
                        </NavItem>
                    </Nav>
                </Navbar.Collapse>
            </Navbar>
        );
    }
}

export default Menu;
