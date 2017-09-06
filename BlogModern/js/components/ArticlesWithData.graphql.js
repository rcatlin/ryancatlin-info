import { graphql } from 'react-apollo';

import Article from '../components/Article.react';
import ArticlesQuery from '../queries/articles';

const ArticlesWithData = graphql(ArticlesQuery, {
    options: {
        notifyOnNetworkStatusChange: true,
        variables: { after: ''}
    },
})(Article);

export default ArticlesWithData;