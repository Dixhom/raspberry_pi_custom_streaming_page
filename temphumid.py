#!/usr/bin/python

import sys
import Adafruit_DHT
import datetime

# Adafruit_DHT.DHT22 : device name
# 4 : pin number
humidity, temperature = Adafruit_DHT.read_retry(Adafruit_DHT.DHT22, 4)

def save_data(path, var, limit=24*60):
        if var is None:
                print 'Failed to get reading. Try again!'
                sys.exit(1)

        # get the last n-1 lines (n=limit)
        with open(path, 'r') as f:
                lines = f.readlines()
                first_index = max(0, len(lines) - limit + 1)
                # ignore empty lines
                lines = [l.strip() for l in lines[first_index:] if l.strip()]

        # append new data
        str = '{0}, {1}'.format(datetime.datetime.now().strftime("%Y/%m/%d %H:%M:%S"), var)
        lines.append(str)

        # concatenate lines
        str = '\n'.join(lines)

        # now write them to csv
        with open(path,"w") as f:
                f.write(str)

path_humid = "/home/dixhom/Adafruit_Python_DHT/examples/humid.csv"
save_data(path_humid, humidity)

path_temp = "/home/dixhom/Adafruit_Python_DHT/examples/temp.csv"
save_data(path_temp, temperature)
