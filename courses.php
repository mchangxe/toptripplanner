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

		$query="SELECT CRN FROM `CourseCatalog`";
        $result = mysqli_query($conn, $query);
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
                <a class="nav-link" href="http://toptripplanner.web.illinois.edu">QUICK START</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="http://toptripplanner.web.illinois.edu/team.php">TEAM</a>
              </li>
            </ul>
          </div>
        </nav>	    
		<script type="text/javascript">
			window.addEventListener('load', function() { 
			    console.log('shuttle: ', sessionStorage.getItem("shuttle"));
			    console.log('course: ', sessionStorage.getItem("course"));
			  }, false);

			var next = 0;
			$(document).ready(function () {
			    //@naresh action dynamic childs
			    $("#add-more").click(function(e){
			        e.preventDefault();
			        var addto = "#field" + next;
			        var addRemove = "#field" + (next);
			        next = next + 1;
			        var newIn = ' <div id="field'+ next +'" name="field'+ next +'"><!-- Text input--><div class="form-group"> <div class="col-md-5"> <input id="action_id'+ next +'" name="action_id'+ next +'" type="text" placeholder="" class="form-control input-md" list="CRNs"> </div></div>';
			        var newInput = $(newIn);
			        $(addto).after(newInput);
			        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
			        $("#count").val(next);    
			    });
			});
		</script>
		<div class="row" align="center" >
			<img src="assets/logo.png" class="float-left" alt="Responsive image" width="200" height="60" style="margin-left: 70px; margin-top: 30px">
		</div>
		<div class="row" align="center" style="margin-top: 50px; margin-left:70px;">
			<h1>Search by course CRN:</h1>
		</div>
		<form>
			<div class="form-group row">
				<div class="col-sm-5" style="margin-left: 100px; margin-top: 30px">
				    <label for="username">Tell us your NetID: </label>
				    <input type="email" class="form-control" id="username" aria-describedby="emailHelp" placeholder="Michael...">
				    <button id="delete" type="delete" class="btn btn-outline-primary" style="margin-top: 10px">DELETE</button>
				</div>
			</div>
		</form>
		<div style="margin-left: 100px; margin-top: 20px">
			<div class="col-xs-12">
	            <div class="col-md-12" >
	                <div id="field">
		                <div id="field0">
							<!-- Text input-->
							<div class="form-group">
							  <div class="col-md-5">
							      <label>Tell us your course CRN</label>
								  <input id="action_id0" name="action_id" type="text" placeholder="ex. 65534" class="form-control input-md" list="CRNs"/>
                                  <datalist id="CRNs">
                                  <option selected>Select...</option>
                                  <?php
                                    while ($row = $result -> fetch_assoc())
                                    {
                              	      $CRN = $row['CRN'];
                              	      echo "<option value='$CRN'>$CRN</option>";
                                    }
                                  ?>
                                  </datalist>
							  </div>
							</div>
						</div>
					</div>
					<!-- Button -->
					<div class="form-group">
					  <div class="col-sm-8">
					    <button id="add-more" name="add-more" class="btn btn-primary">Add More</button>
					  </div>
					</div>         
	            </div>
	        </div>
	    </div>
	    <div class="form-group row" style="margin-bottom: 100px">
					<div class="col-sm-8" style="margin-left: 100px">
						<button id="submit" type="submit" class="btn btn-outline-primary">SUBMIT CRNs</button>
					</div>
					<script type="text/javascript">
						$('#submit').on('click', function (e) {
							//do nothing
							var netid = document.getElementById("username").value;

							var query = '';
							for (var i=0; i<=next; i++){
								var name = 'action_id' + i;
								query += document.getElementById(name).value;
							}

							xhttp = new XMLHttpRequest();
							xhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
							    	console.log(this.responseText);
								}
							};

							var finalq = "upload.php?q="+netid+'&'+'c='+query; 
							console.log(finalq);
							xhttp.open("GET", finalq, true);
							xhttp.send();

							// jump to from to page
							sessionStorage.setItem("got_netid", 1);
							sessionStorage.setItem("netid", netid);
					    	setTimeout('window.location.href="http://toptripplanner.web.illinois.edu/fromto.php"', 0);
						})
						
						$('#delete').on('click', function (e) {
							//do nothing
							var netid = document.getElementById("username").value;

							xhttp = new XMLHttpRequest();
							xhttp.onreadystatechange = function() {
								if (this.readyState == 4 && this.status == 200) {
							    	console.log(this.responseText);
								}
							};

							var finalq = "delete.php?q="+netid; 
							console.log(finalq);
							xhttp.open("GET", finalq, true);
							xhttp.send();
						})
					</script>
				</div>
		<footer class="footer mx-auto py-3" style="margin-top: 30px; bottom: 0; background-color: #435463; width: 100%; position: fixed;">
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
	</body>
</html>