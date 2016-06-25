import React from 'react';

import Article from '../article.react';
import ArticleStore from '../../stores/ArticleStore';

export default class MostRecent extends React.Component {
    static get displayName() {
        return 'MostRecent';
    }

    constructor(props) {
        super(props);

        this.state = {
            articles: [],
        };
    }

    componentDidMount() {
        ArticleStore.getList(this, 0, 1, true);
    }

    render() {
        var mostRecent = this.state.articles.pop();
        
        if (!(mostRecent instanceof Object)) {
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
                content={mostRecent.content}
                createdAt={mostRecent.createdAt}
                id={mostRecent.id}
                key={mostRecent.id}
                slug={mostRecent.slug}
                tags={mostRecent.tags}
                title={mostRecent.title}
            />
        );
    }
}
