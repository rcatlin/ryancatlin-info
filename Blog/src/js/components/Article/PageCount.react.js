var React = require('react');

var ReactPropTypes = React.PropTypes;

var ArticleStore = require('../../stores/ArticleStore');

var PageCount = React.createClass({
    displayName: 'ArticlePageCount',

    propTypes: {
        limit: ReactPropTypes.number.isRequired,
        offset: ReactPropTypes.number.isRequired
    },

    getInitialState: function() {
        return {
            activeCount: undefined // eslint-disable-line no-undefined
        };
    },

    componentDidMount: function() {
        ArticleStore.activeCount(this);
    },

    calculateLimitOffset: function(limit, offset) {
        var current = offset / limit,
            total = this.state.activeCount / limit;

        if (total === 0) {
            total = 1;
        }

        if (current === 0) {
            current = 1;
        }

        if (current > total) {
            current = total;
        }

        return [current, total];
    },

    render: function() {
        var calculatedResult = ['-', '-'],
            current = '-',
            total = '-';

        if (typeof this.state.activeCount === 'number') {
            calculatedResult = this.calculateLimitOffset(
                this.props.limit,
                this.props.offset
            );

            current = calculatedResult[0];
            total = calculatedResult[1];
        }

        return (
            <span className="text-center">
                {' Showing Page '}{current}{' of '}{total}
            </span>
        );
    }
});

module.exports = PageCount;
