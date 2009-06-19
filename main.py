import wsgiref.handlers

from google.appengine.ext import webapp

class IndexHandler(webapp.RequestHandler):
  def get(self):
    self.response.out.write('Hello world!')
    
    
class SendHandler(webapp.RequestHandler):
  def get(self):
    self.response.out.write('Send!')


# Run the app
def main():
  application = webapp.WSGIApplication([('/', IndexHandler), ('/sendconfig/', SendHandler)],
                                       debug=True)
  wsgiref.handlers.CGIHandler().run(application)


if __name__ == '__main__':
  main()
