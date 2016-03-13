var React = require('react');
var ReactPropTypes = React.PropTypes;
var ReactRouter = require('react-router');

var Link = ReactRouter.Link;

var Item = React.createClass({
    displayName: 'Item',

    propTypes: {
        active: ReactPropTypes.bool,
        href: ReactPropTypes.string,
        icon: ReactPropTypes.string.isRequired,
        name: ReactPropTypes.string.isRequired,
        onItemClick: ReactPropTypes.func,
        text: ReactPropTypes.string.isRequired,
        to: ReactPropTypes.string.isRequired
    },

    /**
     * @return {object} The Default Properties.
     */
    getDefaultProps: function() {
        return {
            active: false,
            href: '#'
        };
    },

    handleOnClick: function() {
        this.props.onItemClick(this.props.name);
    },

    render: function() {
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
});

module.exports = Item;
