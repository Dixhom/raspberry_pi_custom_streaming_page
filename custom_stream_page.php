<?php
// For very good security reasons javascript doesn't allow users 
// to access the file without the user first selecting it via an file input control. 
// that's why this program is reading files in php.

// read temperature -----------------------------------------------------------------------
$data = array();
$fp = fopen('/home/dixhom/Adafruit_Python_DHT/examples/temp.csv', 'r');
$row = fgetcsv($fp); // skip the header
$last_temp= 0;
while ($row = fgetcsv($fp)) {
  $data[] = sprintf("['%s', %d] ", $row[0], $row[1]);
  $last_temp = $row[1];
}
fclose($fp);
$last_temp = sprintf("%.2f", $last_temp);
$str_temp = implode(', ' . PHP_EOL, $data);

// read humidity -----------------------------------------------------------------------
$data = array();
$fp = fopen('/home/dixhom/Adafruit_Python_DHT/examples/humid.csv', 'r');
$row = fgetcsv($fp); // skip the header
$last_humid = 0;
while ($row = fgetcsv($fp)) {
  $data[] = sprintf("['%s', %d] ", $row[0], $row[1]);
  $last_humid = $row[1];
}
fclose($fp);
$last_humid = sprintf("%.0f", $last_humid);
$str_humid = implode(', ' . PHP_EOL, $data);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>MJPEG-Streamer</title>
<META http-equiv="Content-Style-Type" content="text/css">
<style type="text/css">
<!--
body {
    color:  #EC008C;
    margin:5px;
    background-color:#EC008C;
    border-collapse:collapse;
}

.main_panel {
    width: 480px;
	text-align: center;
	margin: 40px;
	padding 40px;
	background-color: #fff;
}

.item_name {
    text-align: right;
    font-size: 12px;
}

.text_small {
	font-size: 12px;
}

.text_big {
	font-size: 24px;
}

.graph {
    width: 320px;
}

.page_title {
    background-color: #AC0065;
    color: #ffffff;
    padding: 20px;
}


#table {
    display:table;
    text-align: center;
    }
.row {
    display:table-row;
    }
.row>div {
    display:table-cell;
    margin:15px;
    padding:15px;
}



-->
</style>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<SCRIPT type="text/javascript"><!--
dayOfTheWeek=new Array("Sun","Mon","Tue","Wed","Thu","Fri","Sat");
	months=new Array("Jan.", "Feb.", "Mar.", "Apr.", "May", "Jun.", "Jul.", "Aug.", "Sep.", "Oct.", "Nov.", "Dec.");
	function printDateAndTime(){
		d=new Date();
		date = ""
		date += d.getHours() + ":";
		date += ("0" + d.getMinutes()).slice(-2) + ":";
		date += ("0" + d.getSeconds()).slice(-2) + " ";

		date += dayOfTheWeek[d.getDay()] + ", ";
		date += months[d.getMonth()] + " ";
		date += d.getDate() + ", ";
		date += d.getFullYear();

		document.getElementById("localtime").innerHTML = date;
}

google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(updateTempAndHumid);
  function updateTempAndHumid(){

    // current temp and humid
    document.getElementById("temperature").innerHTML = <?php echo $last_temp; ?> + " °C";
    document.getElementById("humidity").innerHTML = <?php echo $last_humid; ?> + " %";

    // temperature graph
    var array_temp = [['date', 'Average temperature'],
    <?php echo $str_temp ?>
    ];
    for(i=0; i<array_temp.length; i++){
        var s = array_temp[i][0];
        var bits = s.split(/\D/);
        array_temp[i][0] = new Date(bits[0], --bits[1], bits[2], bits[3], bits[4]);
    }
    var data_temp = google.visualization.arrayToDataTable(array_temp);


    var options_temp= {
      legend:{position:'top'},
      hAxis: {
        title: 'Time',
        format: 'HH',
        gridlines: {count:4}
      },
      vAxis: {
          title: 'Temperature'
      },
      colors: ["#EC008C"]
    };

      var chart = new google.visualization.LineChart(document.getElementById('graph_temp'));
      chart.draw(data_temp, options_temp);

      // humiditiy graph
      var array_humid = [['date', 'Average humidity'],
        <?php echo $str_humid ?>
    ];

    for(i=0; i<array_humid.length; i++){
        var s = array_humid[i][0];
        var bits = s.split(/\D/);
        array_humid[i][0] = new Date(bits[0], --bits[1], bits[2], bits[3], bits[4]);
    }
      var data_humid = google.visualization.arrayToDataTable(array_humid);

      var options_humid= {
        legend:{position:'top'},
        hAxis: {
          title: 'Time',
          format: 'HH',
          gridlines: {count:4}
        },
        vAxis: {
            title: 'Humidity'
        },
        colors: ["#EC008C"]
      };

      var chart = new google.visualization.LineChart(document.getElementById('graph_humid'));
      chart.draw(data_humid, options_humid);



}

function updatePage(){
  printDateAndTime();
}
// -->
</SCRIPT>

<SCRIPT type="text/javascript"><!--
setInterval( "updatePage()", 1000 );
// -->
</SCRIPT>
</head>

<body>
<div class="main_panel">
	<h1 class="page_title">VIDEO STREAMING</h1>

    <img src="http://192.168.11.3:8080/?action=stream"/>

    <div id="table">
        <div class="row">
            <div class="item_name"> Temperature </div>
            <div class="text_big" id="temperature"> 20 C-degree </div>
        </div>
        <div class="row">
            <div></div>
            <div><div class= "graph" id="graph_temp"></div></div>
        </div>
        <div class="row">
            <div class="item_name"> Humiditiy </div>
            <div class="text_big" id="humidity"> 40 % </div>
        </div>
        <div class="row">
            <div></div>
            <div><div class= "graph" id="graph_humid"></div></div>
        </div>
        <div class="row">
            <div class="item_name"> Local time </div>
            <div class="text_big" id="localtime"> local time </div>
        </div>
    </div>
</div>
</body>
</html>
