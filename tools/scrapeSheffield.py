import urllib2, re, getpass
##DETERMINE WHICH DB
db_name = "2014_comp10120_x2"
user_name = "mbax4hw2"
passW = "BestTeam2014"
print "Scraping Sheffield"
domain = "http://www.welcometosheffield.co.uk"
cgiAddr ="/dms-connect/search"
searchURL = "?mstat=0&townid=1241&type=events&nojs=1&srchtyp=N&dms=12"


HTMLSource = ""
events = []
counter = 0
wew = ""
url = domain + cgiAddr + searchURL
while url:
        print url
	page = urllib2.urlopen(url)
	try:
		HTMLSource = page.read()
                if counter > 4 :
			if len(re.findall('title="View page 1"', HTMLSource)) > 0: 
				break	
	except:
		pass
	finally:
		page.close()
	eventURLs = re.findall('\?dms=3[^"]*', HTMLSource)
	for i in range(0,len(eventURLs)):
                eventURLs[i] = eventURLs[i].replace("amp;", "")
		print domain+cgiAddr+eventURLs[i]
		try:
			evPage = urllib2.urlopen(domain+cgiAddr+eventURLs[i])
		except:
			next
		try:
			evSource = evPage.read()
		except:
			pass
		finally:
			evPage.close()
		evDetails = []
		evSource = evSource[re.search('<div class="dms3"', evSource).start():].split('</table')[0]
		title = re.search('<h\d>(.*?)</h\d', evSource).group(0).split("/>")[1][:-4]
		date = re.search('<tr class="dmsOpenTime"[^(/]*', evSource, re.S).group(0).split("<td>")[1][:-1]
		location = re.search('Address<\/h2><div class="dmsField-A2"><p>(.*?)<\/', evSource).group(0).split("<p>")[1]
		post = location.split('<br/>')[-1][:-2]
		desc = re.search('Details<\/h2>(.*?)<\/p', evSource, re.S).group(0).split("<p>")[1][:-3]
		events.append([title, desc, location[:-2] + ", Sheffield", post, date])
	counter += 1
	url = domain + cgiAddr + searchURL  + "&setpage=" + str(counter)

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
    if notin(existing, i) and notin(commited, i):
	for j in range(len(i)):
		i[j] = i[j].strip()

        commited.append([None, i[0], i[2], i[4], i[1], i[3]])
        date = i[4].split("-")
        unixTimes = []
        for j in date:
		try:
                	z = j.split(" ")
                	if len(j[1]) == 1:
                  		z[1] = "0"+z[1]

                	if len(j) < 6:
				q = date[0].split(" ")
				z.append(z[2])
                        	z.append(z[3])
                	j = z[0] + " " + z[1] + " " + z[2] + " " + z[3]
 			dt = datetime.datetime.strptime(j.replace("\r\n","").strip(), "%a %d %b %Y")
			unixTimes.append(int((dt - datetime.datetime(1970,1,1)).total_seconds())) 
        		if len(unixTimes) == 1:
				unixTimes.append(unixTimes[0])

        		cur.execute("""INSERT INTO Events
                    		       (`name`, `location`, `startDate`, `endDate`,  `description`,`postcode`,`createdBy`)
                    		       VALUES (%s,%s,%s,%s,%s,%s,%s)""", 
                    		   [i[0], i[2], str(unixTimes[0]), str(unixTimes[1]), i[1], i[3], "108299645860446"])
		except:
			pass

db.commit()
db.close()

print "Scraped Manchester succesfully"
