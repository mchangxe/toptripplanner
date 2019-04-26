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
  <script type="text/javascript">
    window.addEventListener('load', function() { 
        var netid;
        console.log('got netid?: ', sessionStorage.getItem("got_netid"));
        if (sessionStorage.getItem("got_netid") == 1){
          netid = sessionStorage.getItem("netid");
          console.log(netid);
        }

        var selectedShuttle = sessionStorage.getItem("shuttle");
        var selectedCourses = sessionStorage.getItem("course");
        console.log('selectedShuttle: ', selectedShuttle);
        console.log('selectedCourses: ', selectedCourses);
      }, false);
  </script>
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
		<div class="row" align="center" >
			<img src="assets/logo.png" class="float-left" alt="Responsive image" width="200" height="60" style="margin-left: 70px; margin-top: 30px">
		</div>
    <div class="row" align="center" style="margin-top: 50px; margin-left:70px;">

      <h1>YOUR TRAVEL INFO:</h1>
    </div>
	<br>
    <form>
      <div class="form-group row">
        <div class="col-lg-2" style="margin-left: 100px">

          <?php
                $query="SELECT location FROM `Peoria Location` WHERE type = 'P' AND city = 'Urbana/Champaign'";
                $result = mysqli_query($conn, $query);
                ?>
          <select class="custom-select" id="from">
          <option selected>From...</option>
          <?php
            while ($row = $result -> fetch_assoc())
          {
        	    $location = $row['location'];
        	    echo "<option value='$location'>$location</option>";
          }
          ?>
          </select>

        </div>
        <div class="col-lg-2" style="margin-left: 20px">
          <input id="to" type="text" class="form-control" placeholder="To...">
        </div>
      </div>
    </form>   
    <form>
      <div class="form-group row">
        <div class="col-md-2" style="margin-left: 100px">
            <input type="date" id="start" class="form-control"
                   value="2019-05-01"
                   min="2019-05-01" max="2019-05-31" aria-describedby="basic-addon1">
        </div>
        <div class="col-md-2" style="margin-left: 20px">
            <input type="date" id="end" class="form-control"
                   value="2019-05-01"
                   min="2019-05-01" max="2019-05-31" aria-describedby="basic-addon1">
        </div>
      </div>
    </form> 
    <form>
      <div class="form-group row">
        <div class="col-md-2" style="margin-left: 100px">
          <div class="form-check" style="margin-top: 10px">
            <input class="form-check-input" type="radio" name="shuttleSelection" id="sel2" value="option2">
            <label class="form-check-label" for="sel2">
              Round Trip
            </label>
          </div>
        </div>
      </div>
    </form>
    <button id="go" type="button" class="btn btn-outline-info" style="margin-left: 100px; margin-top: 10px">GO</button>
		<script type="text/javascript">
            $('#go').on('click', function (e) {
              //do nothing
              var selectedShuttle = sessionStorage.getItem("shuttle");
              var selectedCourses = sessionStorage.getItem("course");

              var from = document.getElementById("from").value;
              if (selectedShuttle == 0){
                from = 'chi';
              }
              var to = document.getElementById("to").value;
              var dropoff = "O'Hare Terminal 2 Departures";
              var ddate = document.getElementById("start").value;
              var rdate = document.getElementById("end").value;
              var roundtrip = document.getElementById("sel2").checked;

              sessionStorage.setItem("from", from);
              sessionStorage.setItem("to", to);
              sessionStorage.setItem("dropoff", to);
              sessionStorage.setItem("ddate", ddate);
              sessionStorage.setItem("rdate", rdate);
              sessionStorage.setItem("roundtrip", roundtrip);

              if (selectedShuttle == 1){
                // trigger peoria python script
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      console.log(this.responseText);
                  }
                };

                var finalq = "peoria.php?from="+from+'&'+'to='+dropoff+'&ddate='+ddate+'&rdate='+rdate+'&roundtrip='+roundtrip; 
                console.log(finalq);
                xhttp.open("GET", finalq, true);
                xhttp.send();

                if (roundtrip == true){
                  setTimeout('window.location.href="http://toptripplanner.web.illinois.edu/resultsShuttleRT.php"', 0);
                }else{
                  setTimeout('window.location.href="http://toptripplanner.web.illinois.edu/resultsShuttleOW.php"', 0);
                }
              }else{
                if (roundtrip == true){
                  setTimeout('window.location.href="http://toptripplanner.web.illinois.edu/resultsRT.php"', 0);
                }else{
                  setTimeout('window.location.href="http://toptripplanner.web.illinois.edu/resultsOW.php"', 0);
                }
              }
              


            });
    </script>
	</body>
	
	<footer class="footer mx-auto py-3" style="bottom: 0; background-color: #435463; width: 100%; position: fixed;">
		<div class="container mx-auto">
			<?php if($mysqli_connection->connect_error){ ?>
				<img src="assets/notonline.png" class="mx-auto d-block" alt="Responsive image" width="200" height="37" align="center">
			<?php } ?>
			<?php if(!$mysqli_connection->connect_error){ ?>
				<img src="assets/online.png" class="mx-auto d-block" alt="Responsive image" width="100" height="25" align="center">
			<?php } ?>
		</div>
	</footer>
</html>