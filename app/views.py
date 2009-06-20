from django.http import HttpResponse, HttpResponseRedirect
from django.shortcuts import render_to_response
from app.models import *

def index(request):
  message =  request.GET.get('message', False)
  message_type =  request.GET.get('message_type', '')
  if  request.GET.get('manual_apn', '') == 'true':
    form = '_manual_apn_form.html'
  else:
    form = '_carrier_select_form.html'
  #$message = $_GET['message'];
  #$message_type = $_GET['message_type'];
  #$_GET['manual_apn'] == 'true' ? $manual_apn = true : $manual_apn = false;
  c = {'form': form, 'message': message, 'message_type': message_type,
    'carriers': Carrier.all().order("name").fetch(1000)}
  return render_to_response('index.html', c)