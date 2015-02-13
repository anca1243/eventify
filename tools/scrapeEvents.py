import urllib2, re, getpass
##DETERMINE WHICH DB
group = raw_input("Group DB? (y/n) ")
user_name = raw_input("Username: ")

if group == "n":
	db_name = user_name
else:
	db_name = "2014_comp10120_x2"

passW = getpass.getpass()

domain = "https://secure.manchester.gov.uk"
cgiAddr ="/site/custom_scripts/events_search.php"
searchURL = "?searchresults=yes&dateType=anydate"
searchURL += "&date=&startDate=&endDate=&location=Anywhere&offset="
eventURL = "?hideform=yes&displayevent=yes&eventid="

HTMLSource = ""
events = []
url = domain + cgiAddr + searchURL
while url:
	page = urllib2.urlopen(url)
	try:
		HTMLSource = page.read()
	except:
		pass
	finally:
		page.close()
	eventURLs = re.findall(cgiAddr + '\\' + eventURL + '\d*', HTMLSource)
	for event in eventURLs:
		evPage = urllib2.urlopen(domain + event)
		try:
			evSource = evPage.read()
		except:
			pass
		finally:
			evPage.close()
		evDetails = []
		evSource = evSource[re.search('<div id="content"', evSource).start():].split('</section')[0]
		title = re.search('<h\d>(.*?)</h\d', evSource).group(1)
		date = re.search('<span class="icon-calendar"></span>(.*?)</li', evSource, re.S).group(1)
		location = re.search('<span class="icon-location"></span>(.*?)</li', evSource).group(1)
		post = location.split(',')[-1]
		try:
			time = re.search('<span class="icon-clock"></span>(.*?)</li', evSource).group(1)
		except:
			time = ''
		desc = re.search('<article.*?>(.*?)</article', evSource, re.S).group(1)
		events.append([title, desc, location, post, date])

	url = re.search('(' + cgiAddr + '\\' + searchURL + '\d*)">Next Page >>', HTMLSource)
	if url != None:
		url = domain + url.group(1)
	else:
		url = False

def notin(table, obj):
    for i in table:
        if i[1] == obj[0] and i[2] == obj[2]:
            if i[3] == obj[4] and i[4] == obj[1]:
                if i[5] == obj[3]:
                    return False
    return True

import MySQLdb

db = MySQLdb.connect(host="dbhost.cs.man.ac.uk", # your host, usually localhost
                     user=user_name, # your username
                      passwd=passW, # your password
                      db=db_name) # name of the data base

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
	i[1] = i[1].strip().replace("<h2>","")
	for j in range(len(i)):
		i[j] = i[j].strip()

        commited.append([None, i[0], i[2], i[4], i[1], i[3]])
        cur.execute("""INSERT INTO Events
                    (`name`, `location`, `date`, `description`,`postcode`,`createdBy`)
                    VALUES (%s,%s,%s,%s,%s,%s)""", 
                    [i[0], i[2], i[4], i[1], i[3], "71409503111"])
db.commit()
db.close()
