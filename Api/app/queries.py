import graphene


class Query(graphene.ObjectType):
    hello = graphene.String(name=graphene.Argument(graphene.String,
                                                   default_value="World"))

    def resolve_hello(self, args, context, info):
        return 'Hello, ' + args.get('name') + '!'
