import React from 'react';

import MenuActions from '../actions/MenuActions';
import MenuItem from './Menu/item.react';
import MenuStore from '../stores/MenuStore';

export default class Menu extends React.Component {
    constructor(props) {
        super(props);
        
        this.displayName = 'Menu';
        this.state = MenuStore.getAll();

        this.handleChange = this.handleChange.bind(this);
    }

    componentDidMount() {
        MenuStore.addChangeListener(this.handleChange);
    }

    componentWillUnmount() {
        MenuStore.removeChangeListener(this.handleChange);
    }

    handleChange() {
        this.setState(MenuStore.getAll());
    }

    static handleOnItemClick(key) {
        MenuActions.markPageActive(key);
    }

    handleOnLogoClick() {
        self.onItemClick('home');
    }

    render() {
        var active = false,
            index = 'undefined',
            menuItems = [],
            page = 0;

        for (index in this.state.pages) {
            if (this.state.pages.hasOwnProperty(index)) {
                page = this.state.pages[index];

                active = this.state.activePage === index;

                menuItems.push(
                    <MenuItem
                        active={active}
                        href={page.href}
                        icon={page.icon}
                        key={index}
                        name={index}
                        text={page.text}
                        to={page.to}
                    />
                );
            }
        }

        return (
            <nav
                className="navbar navbar-default navbar-fixed-top"
                role="navigation"
            >
                <div className="container-fluid">
                    <div className="navbar-header">
                        <button
                            className="navbar-toggle"
                            data-target="#bs-navbar-collapse-1"
                            data-toggle="collapse"
                            type="button"
                        >
                            <span className="sr-only">
                                {'Toggle navigation'}
                            </span>
                            <span className="icon-bar" />
                            <span className="icon-bar" />
                            <span className="icon-bar" />
                        </button>
                        <a
                            className="navbar-brand"
                            href="/"
                            onClick={this.handleOnLogoClick}
                        >
                            {'ryancatlin.info'}
                        </a>
                    </div>

                    <div
                        className="collapse navbar-collapse"
                        id="bs-navbar-collapse-1"
                    >
                        <ul className="nav navbar-nav">
                            {menuItems}
                        </ul>
                    </div>
                </div>
            </nav>
        );
    }
}
