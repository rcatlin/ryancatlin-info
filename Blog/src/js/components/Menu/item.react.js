import React from 'react';

import {Link} from 'react-router';

export default class Item extends React.Component {
    constructor(props) {
        super(props);
        
        self.displayName = 'Item';
        self.propTypes = {
            active: React.PropTypes.bool,
            href: React.PropTypes.string,
            icon: React.PropTypes.string.isRequired,
            name: React.PropTypes.string.isRequired,
            onItemClick: React.PropTypes.func,
            text: React.PropTypes.string.isRequired,
            to: React.PropTypes.string.isRequired
        };
        self.propTypes = {
            active: false,
            href: '#'
        };
    }

    handleOnClick() {
        this.props.onItemClick(this.props.name);
    }

    render() {
        var iconClass = 'fa fa-' + this.props.icon,
            listItemClass = '';

        if (this.props.active) {
            listItemClass = 'active';
        }

        return (
            <li className={listItemClass}>
                <Link
                    className={iconClass}
                    href="#"
                    name={this.props.name}
                    onClick={this.handleOnClick}
                    to={this.props.to}
                >
                    {' '}{this.props.text}
                </Link>
            </li>
        );
    }
}
