from google.appengine.ext import db

class Carrier(db.Model):
    name = db.StringProperty(default = '')
    apn = db.StringProperty()
    username = db.StringProperty(default = '')
    password = db.StringProperty(default = '')
    listed = db.BooleanProperty(default = False)

class MessageSent(db.Model):
    to = db.EmailProperty()
    when = db.DateTimeProperty(auto_now_add=True)
    carrier = db.ReferenceProperty(Carrier)
    
class BundleDownloaded(db.Model):
    ip = db.StringProperty()
    when = db.DateTimeProperty(auto_now_add=True)
    carrier = db.ReferenceProperty(Carrier)
