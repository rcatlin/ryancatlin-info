import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { ApolloProvider } from 'react-apollo';

import client from './apollo/client';
import ArticlesWithData from './components/ArticlesWithData.graphql';

class App extends Component {
    render() {
        return (
            <ApolloProvider client={ client }>
                <ArticlesWithData />
            </ApolloProvider>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('app'));