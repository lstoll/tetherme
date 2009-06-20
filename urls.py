from django.conf.urls.defaults import *

# Uncomment the next two lines to enable the admin:
# from django.contrib import admin
# admin.autodiscover()

urlpatterns = patterns('',
    (r'^$', 'app.views.index'),
    (r'^admin/$', 'app.views_admin.index'),
    (r'^admin/create_carrier/$', 'app.views_admin.create_carrier'),
    (r'^admin/update_carrier/(.*)/$', 'app.views_admin.update_carrier'),
    (r'^admin/delete_carrier/(.*)/$', 'app.views_admin.delete_carrier'),
    (r'^get_config/(.*)/tether.mobileconfig', 'app.views.get_config'),
    (r'^submit_request/$', 'app.views.submit_request'),
    # Example:
    # (r'^tetherme_django/', include('tetherme_django.foo.urls')),

    # Uncomment the admin/doc line below and add 'django.contrib.admindocs' 
    # to INSTALLED_APPS to enable admin documentation:
    # (r'^admin/doc/', include('django.contrib.admindocs.urls')),

    # Uncomment the next line to enable the admin:
    # (r'^admin/(.*)', admin.site.root),
)
