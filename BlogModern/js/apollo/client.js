import {
	ApolloClient,
	createNetworkInterface
} from 'react-apollo';

export default new ApolloClient({
    networkInterface: createNetworkInterface({
        credentials: 'same-origin',
        headers: {
            'X-CSRFToken': 'xyz',
            token: 'supersecret'
        },
        uri: 'http://localhost:8000/graphql'
    }),
});