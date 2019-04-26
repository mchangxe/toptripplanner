#!/home/toptripplanner/python3/bin/python3.5
import os
import sys
sys.path.insert(0, os.path.dirname(__file__))
import requests
from bs4 import BeautifulSoup
import pymysql.cursors
import datetime
import argparse



def urlinput(tt, pickup, dropoff, ddate):
    url = "https://peoriacharter.com/schedule.php?tt=" + tt + "&pickup_location_id=" + str(pickup) + "&drop_off_location_id=" + str(dropoff) + "&depart_time=" + ddate
    return(url)

def convert24(str1): 
    # Checking if last two elements of time 
    # is AM and first two elements are 12 
    if str1[-2:] == "am" and str1[:2] == "12": 
        return "00" + str1[2:-2] + ":00"   
    # remove the AM     
    elif str1[-2:] == "am": 
        return str1[:-2] + ":00"
    # Checking if last two elements of time 
    # is PM and first two elements are 12    
    elif str1[-2:] == "pm" and str1[:2] == "12": 
        return str1[:-2] + ":00"
    else: 
        # add 12 to hours and remove PM 
        return str(int(str1.split(":")[0]) + 12) + ":" + str1.split(":")[1][:-2] + ":00" 
        
def shuttleschedule(url):
    page = requests.get(url)
    html = BeautifulSoup(page.content, 'html.parser')
    ret = ""
    for schedule in html.find_all("div", attrs={"class": "routeinfodailyschedule"}):
        ret = ret + schedule.getText()
    s = ret.splitlines()
    ddate = url.split('&')[3][12:]
    df = list()
    i = 0
    # row = 0
    while i < len(s):
        if s[i] == "From:":
            print("GOT HERE:", s[i])
            # pick-up location
            fromloc = s[i+1]
            # pick-up time
            dtime = s[i+2]
            # drop-off location
            toloc = s[i+5]
            # drop-off time
            atime = s[i+6]
            durtime = s[i+7]
            date = ddate
            dtime = convert24(dtime)
            atime = convert24(atime)
            if int(dtime.split(":")[0]) > int(atime.split(":")[0]):
                dtime = date + " " + dtime
                date1 = datetime.datetime.strptime(date, "%Y-%m-%d") + datetime.timedelta(days=1)
                date1 = date1.strftime('%Y-%m-%d')
                atime = date1 + " " + atime
            else: 
                dtime = date + " " + dtime
                atime = date + " " + atime
            data = (fromloc, toloc, dtime, atime, durtime)
            #df.loc[row] = data
            df.append(data)
            #row += 1
            i = i+6
        else: 
            i += 1
    return(df)

if __name__ == "__main__":
    ppeoria = {
        'Illinois Terminal': 1,
        'Ikenberry': 3,
        'ISR': 4,
        "O'Hare Bus Shuttle Center": 41,
        "O'Hare Terminal 5 Arrivals": 42,
        'Midway Airport Arrivals': 43
    }

    dpeoria = {
        'Orchard Downs': 64,
        'Midway Airport Departures': 48,
        "O'Hare Terminal 5 Departures": 47,
        'Illinois Terminal': 20,
        'Ikenberry': 22,
        'ISR': 23,
        "O'Hare Terminal 2 Departures": 46
    }
    print("a")
    argparser = argparse.ArgumentParser()
    argparser.add_argument('tt', default='OW', help='One way(OW) or Round trip (RT)')
    argparser.add_argument('pickup', default='ISR', help='Pickup location id')
    argparser.add_argument('ddate', help='date to departure YYYY-MM-DD')
    argparser.add_argument('rdate', help='date to return YYYY-MM-DD can be an empty string')

    args = argparser.parse_args()
    tt = args.tt
    pickup = ppeoria[args.pickup]
    dropoff = dpeoria["O'Hare Terminal 2 Departures"]
    ddate = args.ddate
    rdate = args.rdate
    
    print("Fetching shuttle details")
    url = urlinput('OW', pickup, dropoff, ddate)
    print(url)
    df = shuttleschedule(url)

    if tt == 'RT':
        print('GOT RDF')
        pickup = ppeoria["O'Hare Terminal 5 Arrivals"]
        dropoff = dpeoria[args.pickup]
        rurl = urlinput('OW', pickup, dropoff, rdate)
        rdf = shuttleschedule(rurl)
        print(rdf)

    # Connect to the database
    connection = pymysql.connect(host='localhost',
                                 user='toptripplanner_mchangxe',
                                 password='Ilym201883!',
                                 db='toptripplanner_db',
                                 charset='utf8mb4',
                                 cursorclass=pymysql.cursors.DictCursor)
    try:
        with connection.cursor() as cursor:
            # Create a new record
            sql = "DELETE FROM PeoriaSchedule"
            cursor.execute(sql)
            sql = "INSERT INTO PeoriaSchedule (pickup, dropoff, departureTime, arrivalTime, Duration) VALUES (%s, %s, %s, %s, %s)"
            cursor.executemany(sql, df)
            print(df)
            if tt == 'RT':
                print('EXECUTED')
                sql = "DELETE FROM PeoriaSchedule2"
                cursor.execute(sql)
                sql = "INSERT INTO PeoriaSchedule2 (pickup, dropoff, departureTime, arrivalTime, Duration) VALUES (%s, %s, %s, %s, %s)"
                cursor.executemany(sql, rdf)
                print('*************************')
                print(rdf)
            
            connection.commit()
            
    finally:
        connection.close()
    