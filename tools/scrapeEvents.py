from selenium import webdriver
import time
from selenium.webdriver.common.keys import Keys

#open a browser
try:
    browser = webdriver.Firefox()
except:
    browser = webdriver.Chrome()

url = "https://secure.manchester.gov.uk"
url +="/site/custom_scripts/events_search.php?"
url += "searchresults=yes&dateType=anydate"
url += "&date=&startDate=&endDate=&location=Anywhere&offset="

class event():
    def __init__(self, title, desc, loc, post, date):
        self.title = title
        self.desc = desc.split("Learn")[0]
        self.loc = loc
        self.post = post
        self.date = date
    def getTitle(self):
        return self.title
    def getLocation(self):
        return self.loc
    def getPostcode(self):
        return self.post
    def getDate(self):
        return self.date
    def getDesc(self):
        return self.desc

def sleep(a):
    time.sleep(a)

    
def addPage(offset):
    print "Scraping page "+str(offset)
    events = []
    browser.get(url + str(offset*10))
    eventList =  [x.text.split("\n")[0]
                for x in browser.find_elements_by_class_name("news-item")]
    for i in range(len(eventList)):
        browser.get(url + str(offset*10))
        title = eventList[i]
        link = browser.find_element_by_link_text(title)
        link.click()
        sleep(0.5)
        date = browser.find_element_by_xpath("//div[@id='content']/section/aside/ul/li[1]").text
        location = browser.find_element_by_xpath("//div[@id='content']/section/aside/ul/li[2]").text
        post = location.split(",")[-1]
        time = browser.find_element_by_xpath("//div[@id='content']/section/aside/ul/li[3]").text
        desc = browser.find_element_by_xpath("//div[@id='content']/section/article").text
        events.append(event(title, desc, location, post, date))
    return events
  

currentPage = 0

events = []
                
while True:
    try:
      newpage = addPage(currentPage)
      for i in newpage:
          events.append(i)
      if len(newpage) == 0:
        break
      currentPage +=1
    except Exception as ex:
      print ex
      #Reached end of events
      break
browser.close()

def notin(table, obj):
    for i in table:
        if i[1] == obj.getTitle() and i[2] == obj.getLocation():
            if i[3] == obj.getDate() and i[4] == obj.getDesc():
                if i[5] == obj.getPostCode():
                    return False
    return True

import MySQLdb

db = MySQLdb.connect(host="dbhost.cs.man.ac.uk", # your host, usually localhost
                     user="mbax4hw2", # your username
                      passwd="BestTeam2014", # your password
                      db="2014_comp10120_x2") # name of the data base

# you must create a Cursor object. It will let
#  you execute all the queries you need
cur = db.cursor() 

# Use all the SQL you like
#Get all events
cur.execute("SELECT * FROM Events");
existing = cur.fetchall()
commited = []
for i in events:
    if notin(existing, i) and notin(commited, i):
        commited.append(i)
        cur.execute("""INSERT INTO Events
                    (`name`, `location`, `date`, `description`,`postcode`)
                    VALUES (%s,%s,%s,%s,%s)""", [i.getTitle(), i.getLocation(), i.getDate(), i.getDesc(), i.getPostcode()])
db.commit()
db.close()
    

    
    

