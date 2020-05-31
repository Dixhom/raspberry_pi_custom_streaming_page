# Setting up custom streaming page in Rasberry Pi

## Instruments
- Raspberry Pi 2 Model B v1.1
- Micro SD card
- Web camera (Logicool)
- Temperature and humidity sensor (DHT22)

## Procedure
1. Install mjpg-streamer

	sudo apt-get install -y subversion libjpeg-dev imagemagick  
	svn co https://svn.code.sf.net/p/mjpg-streamer/code/mjpg-streamer mjpg-streamer  
	cd mjpg-streamer  
	make  
	sudo make install  

`~/mjpg-streamer/start_server.sh` should be like below:  

	#!/bin/sh
	
	PORT="8080"
	ID="(your username here)"
	PW="(your password here)"
	SIZE="320x240"
	FRAMERATE="10"
	export LD_LIBRARY_PATH=/usr/local/lib

	DIR=/home/(your username here)/mjpg-streamer
	$DIR/mjpg_streamer \
		-i "$DIR/input_uvc.so -f $FRAMERATE -r $SIZE -d /dev/video0 -y -n" \
		-o "$DIR/output_http.so -w $DIR/www -p $PORT -c $ID:$PW"

2. For automatically start streaming server, add the path to `/etc/rc.local`.

	sudo sh /home/dixhom/mjpg-streamer/start_server.sh

3. Install Adafruit python library. Check this tutorial https://learn.adafruit.com/dht-humidity-sensing-on-raspberry-pi-with-gdocs-logging/overview

4. Run `temphumid.py` periodically by `cron`.

4. Start a web server with PHP. 

5. Open `http://(your raspberry pi's ip address)/custom_stream_page.php` to check the streaming image, temperature and humidity simultaneously.
