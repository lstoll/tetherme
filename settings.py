import os
from ragendja.settings_pre import *

DEBUG=True

# Increase this when you update your media on the production site, so users
# don't have to refresh their cache. By setting this your MEDIA_URL
# automatically becomes /media/MEDIA_VERSION/
MEDIA_VERSION = 1

ROOT_URLCONF = 'urls'  # Replace 'project.urls' with just 'urls'

DATABASE_ENGINE = 'appengine'

MIDDLEWARE_CLASSES = (
    'django.middleware.common.CommonMiddleware',
    'ragendja.auth.middleware.GoogleAuthenticationMiddleware',
    'django.contrib.sessions.middleware.SessionMiddleware',
)

# Change the User model class
AUTH_USER_MODULE = 'ragendja.auth.google_models'
AUTH_ADMIN_MODULE = 'ragendja.auth.google_admin'
LOGIN_URL = '/account/login/'
LOGOUT_URL = '/account/logout/'
LOGIN_REDIRECT_URL = '/'

INSTALLED_APPS = (
    'django.contrib.contenttypes',
    'django.contrib.sites',
    'appenginepatcher',
)

ROOT_PATH = os.path.dirname(__file__)
TEMPLATE_DIRS = (
    ROOT_PATH + '/app/templates',
)

SECRET_KEY = 'AABCDEFS'

from ragendja.settings_post import *
