from selenium import webdriver
from selenium.webdriver.common.keys import Keys
import unittest
import sys
import webbrowser
import time

url = "http://"+sys.argv[1]
print url

class EventifyTestCase(unittest.TestCase):
  def setUp(self):
    try:
      self.browser = webdriver.Firefox()
    except:
      try:
        webbrowser.open("https://www.mozilla.org/en-US/firefox/new/")
        self.browser = webdriver.Chrome()
      except:
        print "Get a real browser"
        sys.exit(1)
      
    self.addCleanup(self.browser.quit)

  def testCheckNavBar(self):
    self.browser.get(url)
    navBar = self.browser.find_element_by_name("navbar").text
    self.assertIn("Home", navBar)
    self.assertIn("Add Event", navBar)
    self.assertIn("Search", navBar)

  def testPageTitle(self):
    self.browser.get(url)
    self.assertIn("Eventify!", self.browser.title)

  def testEventCreation(self):
    self.browser.get(url + "addevent.php")
    title = self.browser.find_element_by_id("evtitle")
    desc = self.browser.find_element_by_id("evdescription")
    loc = self.browser.find_element_by_id("evlocation")
    title.send_keys("Test Event")
    desc.send_keys("A test from the test cases, run at " + time.time())
    loc.send_keys("University Of Manchester")
    sub = self.browser.find_element_by_name("createButton")
    sub.submit()
    
if __name__ == '__main__':
  unittest.main(verbosity=2)
