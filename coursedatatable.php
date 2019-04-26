<?php

	$servername = "localhost";
	$username = "toptripplanner_mchangxe";
	$password = "Ilym201883!";
	$dbname = "toptripplanner_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	mysqli_select_db($conn, "toptripplanner_db");
	
	if (isset($_REQUEST["param1"])){
		$courseName = $_REQUEST["param1"];
	}

    $sql="SELECT Course, CRN, sectionNumber, start, end, daysOfTheWeek FROM `CourseCatalog` WHERE Course = '".$courseName."'";

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