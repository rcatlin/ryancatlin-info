import React from 'react';

import Article from '../article.react';
import ArticleStore from '../../stores/ArticleStore';


export default class ArticleById extends React.Component {
    constructor(props) {
        super(props);

        self.displayName = 'ArticleById';
        self.propTypes = {
            params: React.PropTypes.object.isRequired
        };
        self.state = {
            articles: undefined // eslint-disable-line no-undefined
        };
    }

    componentDidMount() {
        var articleId = parseInt(this.props.params.id, 10);

        ArticleStore.getById(this, articleId);
    }

    render() {
        return (<div>{'Hello'}</div>);
        //
        // var article = this.state.article;
        //
        // if (typeof article === 'undefined') {
        //     return (
        //         <div className="panel panel-default">
        //             <div className="panel-body">
        //                 {'Article could not be found.'}
        //             </div>
        //         </div>
        //     );
        // }
        //
        // return (
        //     <Article
        //         content={article.content}
        //         createdAt={article.createdAt}
        //         id={article.id}
        //         key={article.id}
        //         slug={article.slug}
        //         tags={article.tags}
        //         title={article.title}
        //     />
        // );
    }
}

