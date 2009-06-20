from django.http import HttpResponse, HttpResponseRedirect
from django.shortcuts import render_to_response
from django.views.generic.list_detail import object_list
from django.views.generic.create_update import *

from app.models import Carrier

def index(request):
  return object_list(request, Carrier.all().order('-listed'))
  
def create_carrier(request):
    return create_object(request, Carrier, post_save_redirect='/admin')
    
def update_carrier(request, id):
    return update_object(request, Carrier, object_id=id, post_save_redirect='/admin')
    
def delete_carrier(request, id):
    return delete_object(request, Carrier, object_id=id, post_delete_redirect='/admin')