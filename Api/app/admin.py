from django.contrib import admin

from app import models


# Register your models here.
admin.site.register(models.Article)
admin.site.register(models.Tag)