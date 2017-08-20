import graphene
from graphene_django import DjangoObjectType

from app import models



class TagType(DjangoObjectType):
    class Meta:
        model = models.Tag
        interfaces = (graphene.relay.Node,)

    @classmethod
    def get_node(cls, id, context, info):
        return models.Tag.objects.get(pk=id)


class TagConnection(graphene.relay.Connection):
    class Meta:
        node = TagType


class ArticleType(DjangoObjectType):
    class Meta:
        model = models.Article
        interfaces = (graphene.relay.Node,)

    tags  = graphene.relay.ConnectionField(TagConnection)

    @classmethod
    def get_node(cls, id, context, info):
        return models.Article.objects.get(pk=id)

    @graphene.resolve_only_args
    def resolve_tags(self):
        return self.tags.all()