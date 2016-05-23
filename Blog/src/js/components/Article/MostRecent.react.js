import React from 'react';

import Article from '../article.react';
import ArticleStore from '../../stores/ArticleStore';

export default class MostRecent extends React.Component {
    constructor(props) {
        super(props);
        
        this.displayName = 'MostRecent';
        this.state = {
            article: undefined // eslint-disable-line no-undefined
        };
    }

    componentDidMount() {
        ArticleStore.getList(this, 0, 1, true);
    }

    render() {
        var article = this.state.article;

        if (typeof article === 'undefined') {
            return (
                <div className="panel panel-default">
                    <div className="panel-body">
                        {'There seems to be nothing here.'}
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
