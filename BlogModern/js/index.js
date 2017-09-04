import React from 'react';
import ReactDOM from 'react-dom';
import {
    gql,
    ApolloClient,
    createNetworkInterface,
    ApolloProvider,
    graphql
} from 'react-apollo';
import {
    map
} from 'lodash';

const ArticlesWithData = graphql(gql`
    {
      articles (first: 5) {
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
`, { options: { notifyOnNetworkStatusChange: true } })(Article);

function Article({ data }) {
    if (data.loading) {
        return (
            <div>Loading Articles...</div>
        );
    }

    return (
        <div>
            {
                data.articles.edges.map(
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
        </div>
    );
}

class App extends React.Component {
    createClient() {
        return new ApolloClient({
            networkInterface: createNetworkInterface({
                credentials: 'same-origin',
                headers: {
                    'X-CSRFToken': 'xyz',
                    token: 'supersecret'
                },
                uri: 'http://localhost:8000/graphql'
            }),
        });
    }

    render() {
        return (
            <ApolloProvider client={this.createClient()}>
                <ArticlesWithData />
            </ApolloProvider>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('app'));