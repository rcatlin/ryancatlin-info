import React, { Component, PropTypes } from 'react';
import {
    Button,
    ButtonToolbar
} from 'react-bootstrap-bk';
import { map } from 'lodash';

class Article extends Component {
    getDisplayName() {
        return 'Article';
    }

    render () {
        var moreButton;

        if (this.props.loading) {
            return (
                <div>Loading Articles...</div>
            );
        }

        if (this.props.articles.pageInfo.hasNextPage) {
            moreButton = <Button onClick={ this.props.loadMoreArticles }>More</Button>;
        } else {
            moreButton = <Button disabled>More</Button>;
        }

        return (
            <div>
                {
                    this.props.articles.edges.map(
                        (edge) => {
                            return (
                                <p key={ edge.node.id }>
                                    <span>
                                        <b>{ edge.node.title }</b>
                                    </span>
                                    <br />
                                    <span>{ edge.node.content }</span>
                                </p>
                            );
                        }
                    )
                }
                { moreButton }
            </div>
        );
    }
}

Article.propTypes = PropTypes.shape({
    loading: PropTypes.bool.isRequired,
    articles: PropTypes.shape({
        pageInfo: PropTypes.shape({
            hasNextPage: PropTypes.bool.isRequired,
            hasPreviousPage: PropTypes.bool.isRequired,
            startCursor: PropTypes.string.isRequired,
            endCursor: PropTypes.string.isRequired,
        }).isRequired,
        edges: PropTypes.shape({
            node: PropTypes.shape({
                id: PropTypes.number.isRequired,
                slug: PropTypes.string.isRequired,
                title: PropTypes.string.isRequired,
                createdAt: PropTypes.string.isRequired,
                updatedAt: PropTypes.string.isRequired,
                content: PropTypes.string.isRequired,
                active: PropTypes.bool.isRequired,
                tags: PropTypes.shape({
                    edges: PropTypes.shape({
                        node: PropTypes.shape({
                            id: PropTypes.number.isRequired,
                            name: PropTypes.string.isRequired,
                        }).isRequired,
                    }).isRequired,
                }).isRequired,
            }).isRequired,
        }).isRequired,
    }).isRequired,
    loadMoreArticles: PropTypes.func.isRequired,
});


export default Article;