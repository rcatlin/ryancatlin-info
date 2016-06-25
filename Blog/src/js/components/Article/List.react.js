import React from 'react';

import ArticleShort from '../articleShort.react';
import ArticleStore from '../../stores/ArticleStore';
import PageCount from './PageCount.react';

export default class List extends React.Component {
    static get displayName() {
        return 'ArticleList';
    }

    constructor(props) {
        super(props);

        this.state = {
            offset: 0,
            limit: 10,
            articles: []
        };
    }

    componentDidMount() {
        ArticleStore.getList(
            this,
            this.state.offset,
            this.state.limit
        );
    }

    render() {
        var article = 'undefined',
            index = 'undefined',
            rendered = [];

        for (index in this.state.articles) {
            if (this.state.articles.hasOwnProperty(index)) {
                article = this.state.articles[index];

                rendered.push(
                    <ArticleShort
                        createdAt={article.createdAt}
                        id={article.id}
                        key={article.id}
                        slug={article.slug}
                        title={article.title}
                    />
                );
            }
        }

        return (
            <div>
                <h1 className="text-center">
                    {'Articles'}<br />
                    <small>
                        <PageCount
                            limit={this.state.limit}
                            offset={this.state.offset}
                        />
                    </small>
                </h1>
                {rendered}
            </div>
        );
    }
}
