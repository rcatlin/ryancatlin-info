import React from 'react';

import {Link} from 'react-router';

import MenuActions from '../../actions/MenuActions';

export default class Item extends React.Component {
    constructor(props) {
        super(props);
        
        self.displayName = 'Item';
        self.propTypes = {
            active: React.PropTypes.bool.isRequired,
            href: React.PropTypes.string.isRequired,
            icon: React.PropTypes.string.isRequired,
            name: React.PropTypes.string.isRequired,
            text: React.PropTypes.string.isRequired,
            to: React.PropTypes.string.isRequired
        };

        this.handleClick = this.handleClick.bind(this);
    }

    handleClick() {
        MenuActions.markPageActive(this.props.name);
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
                    onClick={this.handleClick}
                    to={this.props.to}
                >
                    {' '}{this.props.text}
                </Link>
            </li>
        );
    }
}
