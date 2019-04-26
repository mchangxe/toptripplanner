<?php

	$servername = "localhost";
	$username = "toptripplanner_mchangxe";
	$password = "Ilym201883!";
	$dbname = "toptripplanner_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	mysqli_select_db($conn, "toptripplanner_db");
	
	$date = $_REQUEST["date"];
	$return = $_REQUEST["return"];
	$sortByTime = $_REQUEST["sortByTime"];
	$sortByPrice = $_REQUEST["sortByPrice"];

	if ($return == 0){
		//means get info from FlightSchedule
		$sql="SELECT stops, ticket_price, departure, arrival, flight_duration, airline, departure_time, arrival_time FROM `FlightSchedule` WHERE cast(departure_time as Date) = '".$date."'";
	} else{
		//means get info from FlightSchedule2! This is the return trip
		$sql="SELECT stops, ticket_price, departure, arrival, flight_duration, airline, departure_time, arrival_time FROM `FlightSchedule2` WHERE date = '".$date."'";
	}

	if ($sortByTime == 'true'){
		$sort = " ORDER BY flight_duration";
		$sql .= $sort;
	}

	if ($sortByPrice == 'true'){
		$sort = " ORDER BY ticket_price";
		$sql .= $sort;
	}

	$resultset = mysqli_query($conn, $sql) or die("database error:".mysqli_error($conn));

	$data = array();
	while ($row = mysqli_fetch_assoc($resultset)) {
		$data[] = $row;
	}

	$results = array(
		"sEcho" => 1,
		"iTotalRecords" => count($data),
		"iTotalDisplayRecords" => count($data),
		"aaData" => $data
	);

	echo json_encode($results);
?>