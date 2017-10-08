import React, { Component, PropTypes } from 'react';
import { Glyphicon } from 'react-bootstrap-bk';

class Article extends Component {
	render() {
		const createdDate = new Date(this.props.createdAt);

		return (
			<div key={ this.props.id }>
                <div bsStyle="panel-heading text-center">
                    <h1>
                        { this.props.title }
                        <br />
                        <small>
                            {
                                createdDate.getMonth()
                                + '-' +
                                createdDate.getDay()
                                + '-' +
                                createdDate.getFullYear()
                            }
                        </small>
                    </h1>
                </div>
                

                <p bsStyle="text-center">
                    <Glyphicon glyph="tags" />
                    {
                        this.props.tags.edges.map(
                            (edge) => {
                                return (
                                    <a href="#">
                                        { this.props.name }
                                    </a>
                                );
                            }
                        )
                    }
                </p>

                <p>
                    { this.props.content }
                </p>

                <p> </p>
                <hr />
            </div>
		);
	}
}

Article.propTypes = {
	id: PropTypes.number.isRequired,
    slug: PropTypes.string.isRequired,
    title: PropTypes.string.isRequired,
    createdAt: PropTypes.string.isRequired,
    updatedAt: PropTypes.string.isRequired,
    content: PropTypes.string.isRequired,
    active: PropTypes.bool.isRequired,
    tags: PropTypes.shape({
        edges: PropTypes.shape({
            node: PropTypes.shape({
                id: PropTypes.number.isRequired,
                name: PropTypes.string.isRequired,
            }).isRequired,
        }).isRequired,
    }).isRequired,
};

export default Article;