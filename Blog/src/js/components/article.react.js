import React, {Component, PropTypes} from 'react';

import {Link} from 'react-router';

export default class Article extends Component {
    static get displayName() {
        return 'Article';
    }

    constructor(props) {
        super(props);

        Article.propTypes = {
            content: PropTypes.string.isRequired,
            createdAt: PropTypes.string.isRequired,
            id: PropTypes.number.isRequired,
            slug: PropTypes.string.isRequired,
            tags: PropTypes.array.isRequired,
            title: PropTypes.string.isRequired
        };
    }
    
    render() {
        var index = 'undefined',
            tagName = '',
            tags = [];

        for (index in this.props.tags) {
            if (typeof index === 'number') {
                tagName = this.props.tags[index].name;

                tags.push(
                    <a
                        href="#"
                        key={tagName}
                        tagName={tagName}
                    >
                        {'#'}{tagName}
                    </a>
                );
            }
        }

        return (
            <div>
                <div className="panel-heading text-center">
                    <h1>
                        <Link to={'/articles/' + this.props.id}>
                            {this.props.title}
                        </Link>
                        <br />
                        <small>
                            {this.props.createdAt}
                        </small>
                    </h1>
                </div>

                <p className="text-center">
                    {tags}
                    <a href="#">
                        <i className="fa fa-link" />
                    </a>
                </p>

                <p>{this.props.content}</p>
            </div>
        );
    }
}
