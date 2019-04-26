<?php
	$servername = "localhost";
	$username = "toptripplanner_mchangxe";
	$password = "Ilym201883!";
	$dbname = "toptripplanner_db";

	// Create connection
	$conn = new mysqli($servername, $username, $password);
	mysqli_select_db($conn, "toptripplanner_db");
	
	$netid = $_GET['q'];
	$crns = str_split($_GET['c'], 5);

	$sql = "DELETE FROM CourseHistory WHERE netid=?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $netid);
	$stmt->execute();

	foreach ($crns as $crn) {
		$sql = "INSERT INTO CourseHistory (netid, crns) VALUES (?, ?)";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param("ss", $netid, $crn);
		$stmt->execute();
	}
	
	$stmt->close();

	echo("<h1>RESPONSE RECEIVED</h1>");
?>