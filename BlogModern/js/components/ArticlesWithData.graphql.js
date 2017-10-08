import { graphql } from 'react-apollo';

import client from '../apollo/client';
import ArticleList from '../components/ArticleList.react';
import ArticlesQuery from '../queries/articles';

const ArticlesWithData = graphql(ArticlesQuery, {
    props({ data }) {
        const { loading, articles, fetchMore } = data;
        
        const loadMoreArticles = () => {
            return fetchMore({
                query: ArticlesQuery,
                variables: {
                    after: articles.pageInfo.endCursor,
                },
                updateQuery: (previousResult, { fetchMoreResult }) => {
                    const newEdges = fetchMoreResult.articles.edges;
                    const pageInfo = fetchMoreResult.articles.pageInfo;

                    return {
                        articles: {
                            edges: [
                                ...previousResult.articles.edges,
                                ...newEdges,
                            ],
                            pageInfo,
                        },
                    };
                },
            });
        };
        
        return {
            loading,
            articles,
            loadMoreArticles
        };
    },
    options: {
        notifyOnNetworkStatusChange: true,
        variables: { after: ''}
    },
})(ArticleList);

export default ArticlesWithData;