from django.db import models


class Tag(models.Model):
    name = models.CharField(max_length=100,
                            unique=True)

class Article(models.Model):
    slug = models.CharField(max_length=100,
                            unique=True)
    title = models.CharField(max_length=255)
    created_at = models.DateTimeField(auto_now_add=True)
    updated_at = models.DateTimeField(auto_now=True)
    content = models.TextField()
    active = models.BooleanField()
    tags = models.ManyToManyField(Tag)