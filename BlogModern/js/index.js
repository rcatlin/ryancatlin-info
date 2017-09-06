import React, { Component, PropTypes } from 'react';
import ReactDOM from 'react-dom';
import {
    graphql,
    ApolloProvider
} from 'react-apollo';

import client from './apollo/client';
import Article from './components/Article.react';
import ArticlesQuery from './queries/articles';

const ArticlesWithData = graphql(ArticlesQuery, {
    options: {
        notifyOnNetworkStatusChange: true,
        variables: { after: ''}
    },
})(Article);

class App extends React.Component {
    render() {
        return (
            <ApolloProvider client={ client }>
                <ArticlesWithData />
            </ApolloProvider>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('app'));