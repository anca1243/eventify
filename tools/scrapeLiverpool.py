import urllib2, re, getpass, os

os.environ['http_proxy']=''
user_name = "mbax4hw2"
db_name = "2014_comp10120_x2"
print "Scraping Liverpool"
passW = "BestTeam2014"

#http://www.visitliverpool.com/whats-on/searchresults?sr=1&rd=on&stay=&end=&anydate=yes
domain = "http://www.visitliverpool.com"
cgiAddr ="/whats-on/"
searchURL = "/searchresults?sr=1&rd=on&stay=&end=&anydate=yes"
eventURL = "?hideform=yes&displayevent=yes&eventid="

HTMLSource = ""
events = []
url = domain + cgiAddr + searchURL
counter = 1
while url:
        page = urllib2.urlopen(url);
        #print url
	try:
		HTMLSource = page.read()
                if "No results found" in HTMLSource:
			break
	except:
		pass
	finally:
		page.close()
	eventURLs = re.findall(domain + cgiAddr + '[A-Za-z0-9-]*', HTMLSource)
	for i in range(0,len(eventURLs),2):
		evPage = urllib2.urlopen(eventURLs[i])
		#print eventURLs[i]
		try:
			evSource = evPage.read()
		except:
			pass
		finally:
			evPage.close()
		evDetails = []
		title = re.search('class="nameWrapper"><h1>[^<]*', evSource).group(0)
		date = re.search('date\">[^<]*', evSource).group(0)
                try:
			desc = re.search('About<\/h2>[^/]*', evSource).group(0)
		except:
			desc = ""
		try:
			location = re.search('<address><span>[^<]*', evSource).group(0)
		except:
			location = ""
                try :
			post =re.search('</span><br /><span>[^(</span>)]*', evSource).group(0)
		except:
			post = ""
		#try:
		#	time = 
		#except:
		#	time = ''
		#desc = 
		events.append([title[24:], desc[15:-1], location[15:]+", Liverpool", post[19:], date[7:-1]])
	counter += 1
	url = 'http://www.visitliverpool.com/whats-on/searchresults?p='+str(counter)+'&sr=1&stay=&rd=on&end=&anydate=yes'
	print url

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

import datetime

for i in events:
    #Get rid of the h2s
    i[1] = i[1].replace("<h2>","").replace("</h2>","")
    for j in range(len(i)):
        i[j] = i[j].strip().replace("Back to search results","")
    if notin(existing, i) and notin(commited, i):
	i[1] = i[1].strip().replace("<h2>","")
	for j in range(len(i)):
		i[j] = i[j].strip()

        commited.append([None, i[0], i[2], i[4], i[1], i[3]])
        date = i[4].split("-")
        unixTimes = []
        for j in date:
 		dt = datetime.datetime.strptime(j.replace("\r\n","").strip(), "%d/%m/%Y")
		unixTimes.append(int((dt - datetime.datetime(1970,1,1)).total_seconds())) 
        if len(unixTimes) == 1:
		unixTimes.append(unixTimes[0])

        cur.execute("""INSERT INTO Events
                    (`name`, `location`, `startDate`, `endDate`,  `description`,`postcode`,`createdBy`)
                    VALUES (%s,%s,%s,%s,%s,%s,%s)""", 
                    [i[0], i[2], str(unixTimes[0]), str(unixTimes[1]), i[1], i[3], "110332012350598"])

db.commit()
db.close()
print "Scraped Liverpool Succesfully"
