import graphene
from graphene_django.filter import DjangoFilterConnectionField

from app import mutations, queries


schema = graphene.Schema(mutation=mutations.Mutation,
                         query=queries.Query)
