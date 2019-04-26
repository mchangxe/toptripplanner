<!DOCTYPE html>
<html lang="en">
  	<head>
    	<meta charset="utf-8"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

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
			<h1>QUICK START</h1>
		</div>
		<div style="margin-top: 30px">
			<form>
				<div class="form-group row">
					<div class="col-sm-6" style="margin-left: 100px">
						<input class="form-control" type="text" placeholder="Do you also want shuttle recommendations? (Peoria only)" readonly>
						<small id="shuttleHelp" class="form-text text-muted">*The default search is flights only</small>
						<div class="form-check" style="margin-top: 10px">
				          <input class="form-check-input" type="radio" name="shuttleSelection" id="sel1" value="option1">
				          <label class="form-check-label" for="sel1">
				            Yes
				          </label>
				        </div>
				        <div class="form-check" style="margin-top: 10px">
				          <input class="form-check-input" type="radio" name="shuttleSelection" id="sel2" value="option2">
				          <label class="form-check-label" for="sel2">
				            No
				          </label>
				        </div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-8" style="margin-left: 100px">
						<input class="form-control" type="text" placeholder="Do you want to enter your courses? More specifically, do you care about missing classes?" readonly>
						<small id="shuttleHelp" class="form-text text-muted">*If select no, will disregard your course schedule</small>
						<div class="form-check" style="margin-top: 10px">
				          <input class="form-check-input" type="radio" name="courseSelection" id="sel3" value="option1">
				          <label class="form-check-label" for="sel3">
				            Yes
				          </label>
				        </div>
				        <div class="form-check" style="margin-top: 10px">
				          <input class="form-check-input" type="radio" name="courseSelection" id="sel4" value="option2">
				          <label class="form-check-label" for="sel4">
				            No
				          </label>
				        </div>
					</div>
				</div>
				<div class="form-group row">
					<div class="col-sm-8" style="margin-left: 100px">
						<button id="submit" type="submit" class="btn btn-outline-primary">START TRIP PLANNING</button>
					</div>
					<script type="text/javascript">
						$('#submit').on('click', function (e) {

						    //try getting values
						    var shuttleYes = document.getElementById("sel1").checked;
						    var shuttleNo = document.getElementById("sel2").checked;
						    var courseYes = document.getElementById("sel3").checked;
						    var courseNo = document.getElementById("sel4").checked;
						    if (courseYes){
						    	sessionStorage.setItem("course", 1);
						    }

						    if (courseNo){
						    	sessionStorage.setItem("course", 0);
						    } 

						    if (shuttleYes){
						    	sessionStorage.setItem("shuttle", 1);
						    }

						    if (shuttleNo){
						    	sessionStorage.setItem("shuttle", 0);
						    }
						    
						    var course = sessionStorage.getItem("course");
						    console.log(course);
						    if (course == 1) {
						    	setTimeout('window.location.href="http://toptripplanner.web.illinois.edu/searchpreference.php"', 0);
						    }else{
						    	sessionStorage.setItem("got_netid", 0);
						    	setTimeout('window.location.href="http://toptripplanner.web.illinois.edu/fromto.php"', 0);
						    }
						})
					</script>
				</div>
			</form>
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