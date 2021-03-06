<!DOCTYPE html>
<html lang="en">
  	<head>
    	<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
		<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

		<script type=""></script>
  	</head>
	<?php
		$servername = "localhost";
		$username = "toptripplanner_mchangxe";
		$password = "Ilym201883!";
		$dbname = "toptripplanner_db";

		// Create connection
		$conn = new mysqli($servername, $username, $password);
		mysqli_select_db($conn, "toptripplanner_db");
	?>
	<script type="text/javascript">
        $(document).ready(function () {
        	$("#getButton").click(function(e){ 

        		console.log($('#sel1').is(":checked"));
        		console.log($('#sel2').is(":checked"));
        		var tableTo = $('#rwto').DataTable({
        			retrieve: true,
					searching: false, 
					paging: false, 
					info: false,
					ajax: {
						url: 'getflightshuttleonly.php',
						data: function(d){
							d.from = sessionStorage.getItem("from")
				            d.date = sessionStorage.getItem("ddate")
				            d.return = 0;
				            d.sortByTime = $('#sel1').is(":checked")
				            d.sortByPrice = $('#sel2').is(":checked")
				            d.gotcourses = sessionStorage.getItem("got_netid")
				            d.netid = sessionStorage.getItem("netid")
				        }
					},
					columns: [
						{mData: "fullPrice"},
						{mData: "shuttleDepart"},
						{mData: "shuttleArrive"},
						{mData: "flightDepart"},
						{mData: "flightArrive"},
						{mData: "shuttleDuration"},
						{mData: "flightDuration"}
					]
				});
        		tableTo.ajax.reload(null, false);
        	});
		});
	</script>
	<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
          <a class="navbar-brand" href="#">Navbar</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="#">QUICK START<span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="http://toptripplanner.web.illinois.edu/team.php">TEAM</a>
              </li>
            </ul>
          </div>
        </nav>
	    
		<div class="row" align="center" >
			<img src="assets/logo.png" class="float-left" alt="Responsive image" width="200" height="60" style="margin-left: 70px; margin-top: 30px">
		</div>
		<div class="row" align="center" style="margin-top: 50px; margin-left:70px;">
			<h1>RESULTS</h1>
		</div>
		<div style="margin-left: 100px; margin-top: 20px; margin-right: 100px">
			<div class="col-md-12" >
				<div class="form-check" style="margin-top: 10px">
		            <input class="form-check-input" type="radio" name="sorts" id="sel1" value="option2">
		            <label class="form-check-label" for="sel2">Shortest Travel Duration First</label>
		        </div>
			</div>
			<div class="col-md-12" >
				<div class="form-check" style="margin-top: 10px">
		            <input class="form-check-input" type="radio" name="sorts" id="sel2" value="option2">
		            <label class="form-check-label" for="sel2">Cheapest First</label>
		        </div>
			</div>
			<div class="col-md-12" >
				<button name = "getButton" id="getButton" type="submit" class="btn btn-outline-primary" style="margin-top: 10px">GET SCHEDULES</button>
			</div>
			<div style="margin-top: 20px">
				<h4>Departure Schedules</h4>
			</div>
			<table id="rwto" class="table table-striped" style="margin-left: 20px">
				<thead>
					<tr>
						<th scope="col">fullPrice</th>
						<th scope="col">shuttleDepart</th>
						<th scope="col">shuttleArrive</th>
						<th scope="col">flightDepart</th>
						<th scope="col">flightArrive</th>
						<th scope="col">shuttleDuration</th>
						<th scope="col">flightDuration</th>
					</tr>
				</thead>
			</table>
		</div>
	</body>
	<footer class="footer mx-auto py-3" style="bottom: 0; background-color: #435463; width: 100%; position: fixed;">
		<div class="container mx-auto">
			<?php if($mysqli_connection->connect_error){ ?>
				<img src="assets/notonline.png" class="mx-auto d-block" alt="Responsive image" width="200" height="37" align="center">
			<?php } ?>
			<?php if(!$mysqli_connection->connect_error){ ?>
				<img src="assets/online.png" class="mx-auto d-block" alt="Responsive image" width="100" height="25" align="center">
			<?php } ?>
			<?php
				mysqli_close($conn);
			?>
		</div>
	</footer>
</html>