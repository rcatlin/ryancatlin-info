import graphene


from .queries import Query


schema = graphene.Schema(query=Query)