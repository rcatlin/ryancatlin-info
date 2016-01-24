var React = require('react');

var MenuActions = require('../actions/MenuActions');
var MenuItem = require('./Menu/item.react');
var MenuStore = require('../stores/MenuStore');

var Menu = React.createClass({
    displayName: 'Menu',

    /**
     * @return {object} All Menu values.
     */
    getInitialState: function() {
        return MenuStore.getAll();
    },

    componentDidMount: function() {
        MenuStore.addChangeListener(this.handleChange);
    },

    componentWillUnmount: function() {
        MenuStore.removeChangeListener(this.handleChange);
    },

    handleChange: function() {
        this.setState(MenuStore.getAll());
    },

    handleOnItemClick: function(key) {
        MenuActions.markPageActive(key);
    },

    handleOnLogoClick: function() {
        this.onItemClick('home');
    },

    render: function() {
        var active = false,
            index = 0,
            menuItems = [],
            page = 0;

        for (index in this.state.pages) {
            if (typeof index === 'number') {
                page = this.state.pages[index];
                active = this.state.activePage === index;

                menuItems.push(
                    <MenuItem
                        active={active}
                        href={page.href}
                        icon={page.icon}
                        key={index}
                        name={index}
                        onItemClick={this.handleOItemClick}
                        text={page.text}
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
                            <span className="icon-bar"></span>
                            <span className="icon-bar"></span>
                            <span className="icon-bar"></span>
                        </button>
                        <a
                            className="navbar-brand"
                            href="#"
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
});

module.exports = Menu;
