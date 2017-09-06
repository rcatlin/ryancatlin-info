import { gql } from 'react-apollo';

const ArticlesQuery = gql`
    query ListArticles($after: String!){
        articles (
            after: $after,
            first: 5
        ) {
            pageInfo {
              hasNextPage
              hasPreviousPage
              startCursor
              endCursor
            }
            edges {
              node {
                ...article
              }
            }
        }
    }

    fragment article on ArticleType {
      id
      slug
      title
      createdAt
      updatedAt
      content
      active
      tags {
        edges {
          node {
            id
            name
          }
        }
      }
    }
`;

export default ArticlesQuery;
