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
	$gotcourses = $_REQUEST["got_netid"];
	


	if ($gotcourses == '0'){
		// no courses
		// echo "SHOULD NOT BE HERE";
		if ($return == 0){
			//means get info from FlightSchedule
			$sql="SELECT DISTINCT flight.ticket_price + 30 AS fullPrice, PeoriaSchedule.departureTime AS shuttleDepart, PeoriaSchedule.arrivalTime AS shuttleArrive, flight.departure_time AS flightDepart, flight.arrival_time AS flightArrive, PeoriaSchedule.Duration AS shuttleDuration, flight.flight_duration AS flightDuration FROM PeoriaSchedule CROSS JOIN (SELECT stops, ticket_price, departure, arrival, flight_duration, airline, departure_time, arrival_time FROM `FlightSchedule` WHERE cast(departure_time as Date) = '".$date."') AS flight WHERE TIMESTAMPDIFF(HOUR, PeoriaSchedule.arrivalTime, flight.departure_time) BETWEEN 1 AND 2";
		} else{
			//means get info from FlightSchedule2! This is the return trip
			$sql="SELECT DISTINCT flight.ticket_price + 30 AS fullPrice, PeoriaSchedule2.departureTime AS shuttleDepart, PeoriaSchedule2.arrivalTime AS shuttleArrive, flight.departure_time AS flightDepart, flight.arrival_time AS flightArrive, PeoriaSchedule2.Duration AS shuttleDuration, flight.flight_duration AS flightDuration FROM PeoriaSchedule2 CROSS JOIN (SELECT stops, ticket_price, departure, arrival, flight_duration, airline, departure_time, arrival_time FROM `FlightSchedule2` WHERE cast(arrival_time as Date) = '".$date."') AS flight WHERE TIMESTAMPDIFF(HOUR, flight.arrival_time, PeoriaSchedule2.departureTime) BETWEEN 1 AND 2";
		}
		
		if ($sortByTime == "true"){
		    $sort = " ORDER BY flightDuration ASC";
		    $sql .= $sort;
	    }else if ($sortByPrice == "true"){
	    	$sort = " ORDER BY fullPrice ASC";
	    	$sql .= $sort;
	    }
	}else{
		// wow courses!
		$netid = $_REQUEST["netid"];
		if ($return == 0){
			// means get info from FlightSchedule
			// echo "FIRST ONE SHOULD BE HERE";
			$sql="SELECT DISTINCT bigTable1.fullPrice, bigTable1.shuttleDepart, bigTable1.shuttleArrive, bigTable1.flightDepart, bigTable1.flightArrive, bigTable1.shuttleDuration, bigTable1.flightDuration FROM (SELECT DISTINCT DAYOFWEEK(PeoriaSchedule.departureTime) AS day, flight.ticket_price + 30 AS fullPrice, PeoriaSchedule.departureTime AS shuttleDepart, PeoriaSchedule.arrivalTime AS shuttleArrive, flight.departure_time AS flightDepart, flight.arrival_time AS flightArrive, PeoriaSchedule.Duration AS shuttleDuration, flight.flight_duration AS flightDuration FROM PeoriaSchedule CROSS JOIN (SELECT stops, ticket_price, departure, arrival, flight_duration, airline, departure_time, arrival_time FROM `FlightSchedule` WHERE cast(departure_time as Date) = '".$date."') AS flight WHERE TIMESTAMPDIFF(HOUR, PeoriaSchedule.arrivalTime, flight.departure_time) BETWEEN 1 AND 2) AS bigTable1 JOIN (SELECT crns, resultInt, start, end FROM (SELECT * FROM `CourseHistory` JOIN CourseCatalog ON CourseHistory.crns = CourseCatalog.CRN WHERE netid = '".$netid."') AS t1 JOIN dayOfWeek ON t1.daysOfTheWeek = dayOfWeek.dayOfTheWeek) AS courses ON courses.resultInt LIKE CONCAT('%',bigTable1.day,'%') WHERE TIME(bigTable1.shuttleDepart) > courses.end";
		} else{
			//means get info from FlightSchedule2! This is the return trip
			// echo "SECOND ONE SHOULD BE HERE";
			$sql="SELECT DISTINCT bigTable1.fullPrice, bigTable1.shuttleDepart, bigTable1.shuttleArrive, bigTable1.flightDepart, bigTable1.flightArrive, bigTable1.shuttleDuration, bigTable1.flightDuration FROM (SELECT DISTINCT DAYOFWEEK(PeoriaSchedule2.departureTime) AS day, flight.ticket_price + 30 AS fullPrice, PeoriaSchedule2.departureTime AS shuttleDepart, PeoriaSchedule2.arrivalTime AS shuttleArrive, flight.departure_time AS flightDepart, flight.arrival_time AS flightArrive, PeoriaSchedule2.Duration AS shuttleDuration, flight.flight_duration AS flightDuration FROM PeoriaSchedule2 CROSS JOIN (SELECT stops, ticket_price, departure, arrival, flight_duration, airline, departure_time, arrival_time FROM `FlightSchedule2` WHERE cast(arrival_time as Date) = '".$date."') AS flight WHERE TIMESTAMPDIFF(HOUR, flight.arrival_time, PeoriaSchedule2.departureTime) BETWEEN 1 AND 2) AS bigTable1 JOIN (SELECT crns, resultInt, start, end FROM (SELECT * FROM `CourseHistory` JOIN CourseCatalog ON CourseHistory.crns = CourseCatalog.CRN WHERE netid = '".$netid."') AS t1 JOIN dayOfWeek ON t1.daysOfTheWeek = dayOfWeek.dayOfTheWeek) AS courses ON courses.resultInt LIKE CONCAT('%',bigTable1.day,'%') WHERE TIME(bigTable1.shuttleArrive) < courses.start";
		}
		
		if ($sortByTime == "true"){
		  //  echo "1";
		    $sort = " ORDER BY bigTable1.flightDuration ASC";
		    $sql .= $sort;
		  //  echo $sql;
	    }else if ($sortByPrice == "true"){
	       // echo "2";
	    	$sort = " ORDER BY bigTable1.fullPrice ASC";
	    	$sql .= $sort;
	   // 	echo $sql;
	    }

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