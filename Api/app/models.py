from django.db import models


class Article(models.Model):
    slug = models.CharField(max_length=100,
                            unique=True)
    title = models.CharField(max_length=255)
    created_at = models.DateTimeField('date created')
    updated_at = models.DateTimeField('date updated')
    content = models.TextField()
    active = models.BooleanField()
    tags = models.ManyToManyField('Tag')


class Tag(models.Model):
    name = models.CharField(max_length=100,
                            unique=True)
    articles = models.ManyToManyField('Article')