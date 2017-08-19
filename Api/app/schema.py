import graphene
from graphene_django.filter import DjangoFilterConnectionField

from app.queries import Query


schema = graphene.Schema(query=Query)
