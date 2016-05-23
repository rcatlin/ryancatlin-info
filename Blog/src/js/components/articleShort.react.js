import React, {Component, PropTypes} from 'react';

import {Link} from 'react-router';

export default class ArticleShort extends Component {
    constructor(props) {
        super(props);

        self.displayName = 'ArticleShort';
        self.propTypes = {
            createdAt: PropTypes.string.isRequired,
            id: PropTypes.number.isRequired,
            title: PropTypes.string.isRequired
        };
    }

    render() {
        return (
            <div>
                <div className="panel-heading">
                    <h2>
                        <Link to={'/articles/' + this.props.id}>
                            {this.props.title}
                        </Link>
                        {' '}
                        <small>
                            {this.props.createdAt}
                        </small>
                    </h2>
                </div>
            </div>
        );
    }
}