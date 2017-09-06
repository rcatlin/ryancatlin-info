import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { ApolloProvider } from 'react-apollo';

import client from './apollo/client';
import ArticlesWithData from './components/ArticlesWithData.graphql';
import Header from './components/Header.react';

class App extends Component {
    render() {
        return (
        	<div>
            	<Header />
	            <ApolloProvider client={ client }>
	                <ArticlesWithData />
	            </ApolloProvider>
            </div>
        );
    }
}

ReactDOM.render(<App />, document.getElementById('app'));