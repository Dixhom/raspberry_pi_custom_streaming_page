#!/usr/bin/python

import sys
import Adafruit_DHT
import datetime

# Adafruit_DHT.DHT22 : device name
# 4 : pin number
humidity, temperature = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, 4)

def save_data(path, var, limit=24*60):
	if var is not None:	
		# get the last n-1 lines (n=limit)
		with open(path, 'r') as f:
			lines = f.readlines()
			first_index = max(0, len(lines) - limit + 1)
			# ignore empty lines
			lines = [l.strip() for l in lines[first_index:] if l.strip()]
		
		str = '{0}, {1}'.format(datetime.datetime.now().strftime("%Y/%m/%d %H:%M:%S"), var)
		lines.append(str)
		
		# now write'em to csv!
		with open(path,"w") as f:
			for line in lines:
				f.write("%s\n" % line)
		
	else:
		print 'Failed to get reading. Try again!'
		sys.exit(1)

path_humid = "/home/dixhom/Adafruit_Python_DHT/examples/humid.csv"
save_data(path_humid, humidity)

path_temp = "/home/dixhom/Adafruit_Python_DHT/examples/temp.csv"
save_data(path_temp, temperature)
