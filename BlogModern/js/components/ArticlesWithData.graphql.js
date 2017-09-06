import { graphql } from 'react-apollo';

import Article from '../components/Article.react';
import ArticlesQuery from '../queries/articles';

const ArticlesWithData = graphql(ArticlesQuery, {
	props({
		data: {
			loading,
			articles,
			fetchMore
		}
	}) {
		return {
			loading,
			articles,
			loadMoreArticles: () => {
				return fetchMore({
					query: ArticlesQuery,
					variables: {
						cursor: articles.pageInfo.endCursor,
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
				})
			}
		}
	},
    options: {
        notifyOnNetworkStatusChange: true,
        variables: { after: ''}
    },
})(Article);

export default ArticlesWithData;