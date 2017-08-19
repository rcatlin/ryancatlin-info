from django.db.models import BooleanField, CharField, DateTimeField, ManyToManyField, Model, TextField


class Article(Model):
    slug = CharField(max_length=100,
                     unique=True)
    title = CharField(max_length=255)
    created_at = DateTimeField(auto_now_add=True)
    updated_at = DateTimeField(auto_now=True)
    content = TextField()
    active = BooleanField()
    tags = ManyToManyField('Tag')


class Tag(Model):
    name = CharField(max_length=100,
                            unique=True)
    articles = ManyToManyField('Article')