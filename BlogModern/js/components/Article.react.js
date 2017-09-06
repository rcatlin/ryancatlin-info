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
            moreButton = <Button onClick={ this.props.loadMoreArticles } block>More</Button>;
        } else {
            moreButton = <Button disabled block>More</Button>;
        }

        return (
            <div>
                {
                    this.props.articles.edges.map(
                        (edge) => {
                            return (
                                <div key={ edge.node.id }>
                                    <div bsStyle="panel-heading text-center">
                                        <h1>
                                            { edge.node.title }
                                            <br />
                                            <small>
                                                { edge.node.createdAt }
                                            </small>
                                        </h1>
                                    </div>
                                    

                                    <p bsStyle="text-center">
                                        {
                                            edge.node.tags.edges.map(
                                                (edge) => {
                                                    return (
                                                        <a href="#">
                                                            #{ edge.node.name }
                                                        </a>
                                                    );
                                                }
                                            )
                                        }
                                    </p>

                                    <p>
                                        { edge.node.content }
                                    </p>

                                    <p> </p>
                                    <hr />
                                </div>
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