import React, { Component } from 'react';
import { MenuItem, Nav, Navbar, NavItem, NavDropdown } from 'react-bootstrap-bk';


class Menu extends Component {
    render () {
        return (
            <Navbar collapseOnSelect fluid>
                <Navbar.Header>
                    <Navbar.Toggle />
                </Navbar.Header>

                <Navbar.Collapse>
                    <Nav>
                        <NavItem>Main</NavItem>
                        <NavItem>Articles</NavItem>
                        <NavItem>About</NavItem>
                    </Nav>
                </Navbar.Collapse>
            </Navbar>
        );
    }
}

export default Menu;
