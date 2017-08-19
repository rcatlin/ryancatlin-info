import graphene
from graphene_django.filter import DjangoFilterConnectionField

from app import models, types


class Query(graphene.ObjectType):
    node = graphene.relay.Node.Field()

    hello = graphene.String(name=graphene.Argument(graphene.String,
                                                   default_value="World"))

    article = graphene.relay.Node.Field(types.ArticleType)
    articles = DjangoFilterConnectionField(types.ArticleType)

    tag = graphene.relay.Node.Field(types.TagType)
    tags = DjangoFilterConnectionField(types.TagType)

    def resolve_hello(self, args, context, info):
        return 'Hello, ' + args.get('name') + '!'
