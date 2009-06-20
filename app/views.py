from django.http import HttpResponse, HttpResponseRedirect
from django.shortcuts import render_to_response
from django.template.loader import get_template
from django.template import Context
from app.models import *
import urllib
from google.appengine.api import mail

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
    'carriers': Carrier.all().filter('listed =', True).order("name").fetch(1000)}
  return render_to_response('index.html', c)
  
def get_config(request, carrier_id):
  # get the carrier by ID
  carrier = db.get(db.Key(carrier_id))
  
  # Log the download
  log = BundleDownloaded(ip = request.META["REMOTE_ADDR"], ua=request.META["HTTP_USER_AGENT"], carrier=carrier)
  log.put()
  
  # render the details into the template
  t = get_template('mobileconfig.xml')
  c = Context({"carrier": carrier})
  
  # return it.
  response = HttpResponse(t.render(c), mimetype='application/x-apple-aspen-config')
  response['Content-Disposition'] = 'attachment; filename=tether.mobileconfig'
  return response
  
# This needs to be redone with proper forms, not this php like crap
def submit_request(request):
  carrier = request.GET.get('carrier', False)
  apn = request.GET.get('apn', '')
  username = request.GET.get('username', '')
  password = request.GET.get('password', '')
  action = request.GET.get('submit', '')
  to = request.GET.get('to', '')
  
  carrier_id = ''
  # check to see if we have a carrier specified. If so, act on that.
  if carrier:
    carrier_id = carrier
  # otherwise build from params, try to find, if not create, then set the id
  else:
    # if apn not set, redirect home with error.
    if apn == '':
      # redirect home with error
      message = urllib.quote('You must enter an APN!')
      return HttpResponseRedirect('/?manual_apn=true&message_type=error&message=' + message)
    # otherwise, try to find, and if not found create
    query = Carrier.all().filter('apn =', apn).filter('username = ', username).filter('password = ', password)
    results = query.fetch(1)
    for result in results:
      carrier_id = str(result.key())
    if carrier_id == '':
      # no carrier found, create
      carrier = Carrier(apn = apn, username = username, password = password)
      carrier_id = str(carrier.put())
    
  config_uri = request.build_absolute_uri('/get_config/' + carrier_id + '/tether.mobileconfig')
    
  # check the action. If 'Download', redirect the user to the download page for the id
  if action == 'Download':
    return HttpResponseRedirect(config_uri)
  # if 'send', generate a link to the thingy, and mail it. redirect home with status
  else:
    if to == '':
      # redirect home with error
      message = urllib.quote('You must enter a email address to send the details.')
      return HttpResponseRedirect('/?message_type=error&message=' + message)
    else:
      message = mail.EmailMessage(sender="TetherMe <lstoll@lstoll.net>",
                                  subject="Tethering config")

      message.to = to
      message.body = """
      Click on the following link to download the settings.
      Once the settings open, install them - you should then be ready to go with tethering.
    
      %s

      If you have any problems, please e-mail me at the address on the site.

      Enjoy!
      """ % config_uri

      message.send()
      
      log = MessageSent(to = to, carrier=db.get(db.Key(carrier_id)))
      log.put()
    
      statusmsg = urllib.quote('Details sent! Please check your mail on your phone.')
      return HttpResponseRedirect('/?message_type=success&message=' + statusmsg)
  
  #end
  