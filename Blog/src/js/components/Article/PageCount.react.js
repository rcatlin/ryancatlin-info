import React from 'react';

import ArticleStore from '../../stores/ArticleStore';

export default class PageCount extends React.Component {
    static get displayName() {
        return 'ArticlePageCount';
    }

    constructor(props) {
        super(props);

        self.propTypes = {
            limit: React.PropTypes.number.isRequired,
            offset: React.PropTypes.number.isRequired
        };
        this.state = {
            activeCount: undefined // eslint-disable-line no-undefined
        };
    }

    componentDidMount() {
        ArticleStore.activeCount(this);
    }

    calculateLimitOffset(limit, offset) {
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
    }

    render() {
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
}
