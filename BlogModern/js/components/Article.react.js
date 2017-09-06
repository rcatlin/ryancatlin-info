import React, { Component } from 'react';
import {
    Button,
    ButtonToolbar
} from 'react-bootstrap-bk';
import { map } from 'lodash';

class Article extends Component {
    getDisplayName() {
        return 'Article';
    }

    render () {
        var toolbarButtons = [];

        if (this.props.data.loading) {
            return (
                <div>Loading Articles...</div>
            );
        }
        
        if (this.props.data.articles.pageInfo.hasPreviousPage) {
            toolbarButtons.push(<Button>Previous</Button>);
        } else {
            toolbarButtons.push(<Button disabled>Previous</Button>);
        }

        if (this.props.data.articles.pageInfo.hasNextPage) {
            toolbarButtons.push(<Button>Next</Button>);
        } else {
            toolbarButtons.push(<Button disabled>Next</Button>);
        }

        return (
            <div>
                {
                    this.props.data.articles.edges.map(
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
}

export default Article;