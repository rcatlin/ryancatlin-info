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
        var toolbarButtons = [];

        if (this.props.data.loading) {
            return (
                <div>Loading Articles...</div>
            );
        }
        
        if (this.props.data.articles.pageInfo.hasPreviousPage) {
            toolbarButtons.push(<Button>Previous</Button>);
        } else {
            toolbarButtons.push(<Button disabled>Previous</Button>);
        }

        if (this.props.data.articles.pageInfo.hasNextPage) {
            toolbarButtons.push(<Button>Next</Button>);
        } else {
            toolbarButtons.push(<Button disabled>Next</Button>);
        }

        return (
            <div>
                {
                    this.props.data.articles.edges.map(
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
                <ButtonToolbar>{ toolbarButtons }</ButtonToolbar>
            </div>
        );
    }
}

Article.propTypes = PropTypes.shape({
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
});


export default Article;