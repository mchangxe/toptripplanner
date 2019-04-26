<?php
	$servername = "localhost";
	$username = "toptripplanner_mchangxe";
	$password = "Ilym201883!";
	$dbname = "toptripplanner_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	mysqli_select_db($conn, "toptripplanner_db");
	
	$from = $_GET['from'];
	$to = $_GET['to'];
	$date = $_GET['date'];
	$roundtrip = $_GET['roundtrip'];
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	echo $useragent;

	$findflights = shell_exec("/home/toptripplanner/python3/bin/python3.5 searchflights.py $from $to $date");
	echo $findflights;
	echo("RESPONSE RECEIVED");
?>