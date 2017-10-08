import React, { Component, PropTypes } from 'react';
import {
    Button,
    ButtonToolbar
} from 'react-bootstrap-bk';
import { map } from 'lodash';

import Article from './Article.react';

class ArticleList extends Component {
    getDisplayName() {
        return 'Article';
    }

    render () {
        var moreButton,
            loading,
            articles;

        if (this.props.loading) {
            loading = (<div>Loading Articles...</div>);
        } else {
            loading = (<div />);
        }

        if (this.props.articles) {
            articles = this.props.articles.edges.map((edge) => {
                return <Article {...edge.node} />;
            });

            if (this.props.articles.pageInfo.hasNextPage) {
                moreButton = <Button onClick={ this.props.loadMoreArticles } block>More</Button>;
            } else {
                moreButton = <Button disabled block>More</Button>;
            }
        }

        return (
            <div>
                { articles }
                { moreButton }
                { loading }
            </div>
        );
    }
}

ArticleList.propTypes = PropTypes.shape({
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


export default ArticleList;