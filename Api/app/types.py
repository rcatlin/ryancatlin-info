import graphene
from graphene_django import DjangoObjectType
from graphene_django.filter import DjangoFilterConnectionField

from app import models


class TagType(DjangoObjectType):
    class Meta:
        model = models.Tag
        interfaces = (graphene.relay.Node,)

    articles = DjangoFilterConnectionField(lambda: ArticleType)

    @classmethod
    def get_node(cls, id, context, info):
        return models.Tag.objects.get(pk=id)


class ArticleType(DjangoObjectType):
    class Meta:
        model = models.Article
        interfaces = (graphene.relay.Node,)

    tags = DjangoFilterConnectionField(lambda: TagType)

    @classmethod
    def get_node(cls, id, context, info):
        return models.Article.objects.get(pk=id)
