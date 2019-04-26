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
        $('#course tbody').on( 'click', '.checkbox', function() {
            if(this.checked==true)
            {
            	console.log( table.row( this.closest('tr') ).data() );
            }
        });
        var next = 1;

        $(document).ready(function () {

        	$("#add-course0").click(function(e){ 
        		var courseName = document.getElementById("action_id0").value;
        		console.log($('#action_id0').val())
        		var table = $('#course').DataTable({
        			retrieve: true,
					searching: false, 
					paging: false, 
					info: false,
					ajax: {
						url: 'coursedatatable.php',
						data: function(d){
				            d.param1 = $('#action_id0').val();
				        }
					},
					columns: [
						{mData: "Course"},
						{mData: "CRN"},
						{mData: "sectionNumber"},
						{mData: "start"},
						{mData: "end"},
						{mData: "daysOfTheWeek"}
					]
				});
        		table.ajax.reload(null, false);
        	});

        	$("#add-more").click(function(e){
		        e.preventDefault();
		        var addto = "#field" + next;
		        next = next + 1;
		        var newIn = ' <div id="field'+ next +'" name="field'+ next +'"><!-- Text input--><div class="form-group"> <div class="col-md-5"> <input id="action_id'+ next +'" name="action_id'+ next +'" type="text" placeholder="" class="form-control input-md" list="CRNs"> </div></div>';
		        var newInput = $(newIn);
		        $(addto).after(newInput);
		        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
		        $("#count").val(next);    
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
                <a class="nav-link" href="http://toptripplanner.web.illinois.edu">QUICK START</a>
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
			<h1>Search by course name: </h1>
		</div>
		
		<form>
			<div class="form-group row">
				<div class="col-sm-5" style="margin-left: 100px; margin-top: 30px">
				    <label for="username">Step 1: Tell us your NetID:</label>
				    <input type="email" class="form-control" id="username" aria-describedby="emailHelp" placeholder="ex. johns3">
				</div>
			</div>
		</form>
		
		<div style="margin-left: 100px; margin-top: 20px; margin-right: 100px">
			<div class="col-xs-12">
	            <div class="col-md-12" >
	                <div id="field">
		                <div id="field0">
							<!-- Text input-->
							<div class="form-group">
							  <div class="col-md-5">
							  	  <label>Step 2: Use this form here to find CRNs of your course and section</label>
								  <input id="action_id0" name="action_id" type="text" placeholder="ex. AAS 100" class="form-control input-md" list="Courses" />
								            <?php
                                                $query="SELECT DISTINCT Course FROM `CourseCatalog`";
                                                $result = mysqli_query($conn, $query);
                                            ?>
                                              <datalist id="Courses">
                                              <option selected>Select...</option>
                                              <?php
                                                while ($row = $result -> fetch_assoc())
                                              {
                                            	    $Course = $row['Course'];
                                            	    echo "<option value='$Course'>$Course</option>";
                                              }

                                              ?>
                                              </datalist>
                                  <button name = "add-course0" id="add-course0" type="submit" class="btn btn-outline-primary" style="margin-top: 10px">ADD COURSE</button>
							  </div>
							</div>
					              
                            <table id="course" class="table table-striped" style="margin-left: 20px">
								<thead>
									<tr>
										<th scope="col">Course</th>
										<th scope="col">CRN</th>
										<th scope="col">sectionNumber</th>
										<th scope="col">start</th>
										<th scope="col">end</th>
										<th scope="col">daysOfTheWeek</th>
									</tr>
								</thead>
							</table>
						</div>
						<div id="field1" name="field1" style=" margin-top: 10px">
							<!-- Text input-->
							<div class="form-group">
								<div class="col-md-5"> 
									<label>Step 3: Enter CRNs here, use the add more button to add more crn fields</label>
									<input id="action_id1" name="action_id1" type="text" placeholder="" class="form-control input-md">
								</div>
							</div>
						</div>
						<div class="form-group" style="margin-top: 10px">
						  <div class="col-sm-8">
						    <button id="add-more" name="add-more" class="btn btn-primary">Add More</button>
						  </div>
						</div>
					</div>
	            </div>
	        </div>
	    </div>

	    <div class="form-group row">
					<div class="col-sm-8" style="margin-left: 100px; margin-top: 10px; margin-bottom: 100px">
						<button id="submit" type="submit" class="btn btn-outline-primary">SUBMIT</button>
					</div>
					
					<script type="text/javascript">
					
					    // put data to database
						$('#submit').on('click', function (e) {
							//do nothing
							var netid = document.getElementById("username").value;

							var query = '';
							for (var i=1; i<=next; i++){
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