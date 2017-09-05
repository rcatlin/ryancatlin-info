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
    Button,
    ButtonToolbar
} from 'react-bootstrap-bk';
import {
    map
} from 'lodash';

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

const ArticlesWithData = graphql(ArticlesQuery, {
    options: {
        notifyOnNetworkStatusChange: true,
        variables: { after: ''}
    },
})(Article);

function Article({ data }) {
    var toolbarButtons = [];

    if (data.loading) {
        return (
            <div>Loading Articles...</div>
        );
    }
    
    if (data.articles.pageInfo.hasPreviousPage) {
        toolbarButtons.push(<Button>Previous</Button>);
    } else {
        toolbarButtons.push(<Button disabled>Previous</Button>);
    }

    if (data.articles.pageInfo.hasNextPage) {
        toolbarButtons.push(<Button>Next</Button>);
    } else {
        toolbarButtons.push(<Button disabled>Next</Button>);
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
            <ButtonToolbar>{ toolbarButtons }</ButtonToolbar>
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