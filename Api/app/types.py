import graphene
from graphene_django import DjangoObjectType

from app import models


class ArticleType(DjangoObjectType):
    class Meta:
        model = models.Article
        interfaces = (graphene.relay.Node,)

    @classmethod
    def get_node(cls, id, context, info):
        return models.Article.objects.get(pk=id)


class TagType(DjangoObjectType):
    class Meta:
        model = models.Tag
        interfaces = (graphene.relay.Node,)

    @classmethod
    def get_node(cls, id, context, info):
        return models.Tag.objects.get(pk=id)