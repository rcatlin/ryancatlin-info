from base64 import b64decode

import graphene

from app import models, types


def decode_global_id_to_id(id):
    return b64decode(id).decode().split(':')[1:].pop()

class CreateArticle(graphene.relay.ClientIDMutation):
    class Input:
        slug = graphene.String()
        title = graphene.String()
        content = graphene.String()
        active = graphene.Boolean()

    article = graphene.Field(lambda: types.ArticleType)

    @classmethod
    def mutate_and_get_payload(cls, input, context, info):
        article = models.Article.objects.create(slug=input.get('slug'),
                                                title=input.get('title'),
                                                content=input.get('content'),
                                                active=input.get('active'))
        article.save()

        return CreateArticle(article=article)


class CreateTag(graphene.relay.ClientIDMutation):
    class Input:
        name = graphene.String()

    tag = graphene.Field(lambda: types.TagType)

    @classmethod
    def mutate_and_get_payload(cls, input, context, info):
        tag = models.Tag.objects.create(name=input.get('name'))

        tag.save()

        return CreateTag(tag=tag)


class TagArticle(graphene.relay.ClientIDMutation):
    class Input:
        article = graphene.relay.GlobalID()
        tag = graphene.relay.GlobalID()


    article = graphene.Field(lambda: types.ArticleType)

    @classmethod
    def mutate_and_get_payload(cls, input, context, info):
        articleID = decode_global_id_to_id(input.get('article'))
        tagID = decode_global_id_to_id(input.get('tag'))

        article = models.Article.objects.get(pk=articleID)
        tag = models.Tag.objects.get(pk=tagID)

        article.tags.add(tag)
        article.save()

        return TagArticle(article=article)

class Mutation(graphene.ObjectType):
    create_article = CreateArticle.Field()
    create_tag = CreateTag.Field()
    tag_article = TagArticle.Field()


