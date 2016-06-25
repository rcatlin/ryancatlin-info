import React from 'react';

import Article from '../article.react';
import ArticleStore from '../../stores/ArticleStore';


export default class ArticleById extends React.Component {
    static get displayName() {
        return 'ArticleById';
    }

    constructor(props) {
        super(props);
        
        this.propTypes = {
            params: React.PropTypes.object.isRequired
        };
        this.state = {
            article: 'undefined'
        };
    }

    componentDidMount() {
        var articleId = parseInt(this.props.params.id, 10);

        ArticleStore.getById(this, articleId);
    }

    render() {
        var article = this.state.article;

        if (!(article instanceof Object)) {
            return (
                <div className="panel panel-default">
                    <div className="panel-body">
                        {'Article could not be found.'}
                    </div>
                </div>
            );
        }

        return (
            <Article
                content={article.content}
                createdAt={article.createdAt}
                id={article.id}
                key={article.id}
                slug={article.slug}
                tags={article.tags}
                title={article.title}
            />
        );
    }
}

