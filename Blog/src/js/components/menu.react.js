'use strict';

var React = require('react');

var MenuActions = require('../actions/MenuActions');
var MenuItem = require('./Menu/item.react');
var MenuStore = require('../stores/MenuStore');

/**
 * @return {object}
 */
function getState() {
    return MenuStore.getAll();
};

var Menu = React.createClass({
    _onChange: function() {
        this.setState(getState());
    },

    componentDidMount: function() {
        MenuStore.addChangeListener(this._onChange);
    },

    componentWillUnmount: function() {
        MenuStore.removeChangeListener(this._onChange);
    },

    /**
     * @return {object}
     */
    getInitialState: function() {
        return MenuStore.getAll();
    },

    onItemClick: function(key) {
        MenuActions.markPageActive(key);
    },

    onLogoClick: function() {
        this.onItemClick('home');
    },

    render: function() {
        var menuItems = [],
            index,
            page,
            active;

        for (index in this.state.pages) {
            page = this.state.pages[index];
            active = (this.state.activePage == index);

            menuItems.push(
                <MenuItem
                    active={active}
                    icon={page.icon}
                    key={index}
                    name={index}
                    text={page.text}
                    href={page.href}
                    onItemClick={this.onItemClick} />
            );
        }

        return (
            <nav className="navbar navbar-default navbar-fixed-top" role="navigation">

                <div className="container-fluid">
                    <div className="navbar-header">
                        <button type="button" className="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse-1">
                            <span className="sr-only">Toggle navigation</span>
                            <span className="icon-bar"></span>
                            <span className="icon-bar"></span>
                            <span className="icon-bar"></span>
                        </button>
                        <a
                            className="navbar-brand"
                            href="#"
                            onClick={this.onLogoClick}>ryancatlin.info</a>
                    </div>

                    <div className="collapse navbar-collapse" id="bs-navbar-collapse-1">
                        <ul className="nav navbar-nav">{menuItems}</ul>
                    </div>
                </div>
            </nav>
        );
    }
});

module.exports = Menu;
