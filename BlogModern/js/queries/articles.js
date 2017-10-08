import { gql } from 'react-apollo';

const ArticlesQuery = gql`
    query ListArticles ($after: String){
        articles (first: 3, after: $after) {
            pageInfo {
              hasNextPage
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
