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
		<div class="row" align="center" >
			<img src="assets/logo.png" class="float-left" alt="Responsive image" width="200" height="60" style="margin-left: 70px; margin-top: 30px">
		</div>
		<div class="row" align="center" style="margin-top: 50px; margin-left:70px;">
			<h1>Search for courses</h1>
		</div>
		
		<form>
			<div class="form-group row">
				<div class="col-sm-5" style="margin-left: 100px; margin-top: 30px">
				    <label for="username">Tell us your NetID:</label>
				    <input type="email" class="form-control" id="username" aria-describedby="emailHelp" placeholder="ex. johns3">
				    <small id="emailHelp" class="form-text text-muted">This is for demo purposes only...</small>
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
								  <input id="action_id0" name="action_id" type="text" placeholder="ex. AAS 100" class="form-control input-md" list="Courses" />
								            <?php
                                                $query="SELECT DISTINCT Course FROM `Course Catalog`";
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
                                              mysqli_free_result($query);
                                              mysqli_free_result($result);
                                              ?>
                                              </datalist>
 
							  </div>
							</div>
                            <table id="course" class="table table-striped">
                                  <thead>
                                    <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Course</th>
                                      <th scope="col">CRN</th>
                                      <th scope="col">section Number</th>
                                      <th scope="col">start</th>
                                      <th scope="col">end</th>
                                      <th scope="col">daysOfTheWeek</th>
                                      <th scope="col">midterm1</th>
                                      <th scope="col">midterm2</th>
                                      <th scope="col">midterm3</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                            <?php
                                $query="SELECT C.Course, C.CRN, C.sectionNumber, C.start, C.end, C.daysOfTheWeek, S.midterm1, S.midterm2, S.midterm3 FROM `Course Catalog` AS C, `Course Schedule` AS S WHERE C.CRN = S.CRN";
                                $result=mysqli_query($conn, $query);

                                while ($row = mysqli_fetch_array($result))
                                {
                                    echo "<tr>";
                                    echo '<td><input type="checkbox" name="checkbox" value="" id="checkbox"></td>';
                                    echo "<td>" . $row['Course'] . "</td>";
                                    echo "<td>" . $row['CRN'] . "</td>";
                                    echo "<td>" . $row['sectionNumber'] . "</td>";
                                    echo "<td>" . $row['start'] . "</td>";
                                    echo "<td>" . $row['end'] . "</td>";
                                    echo "<td>" . $row['daysOfTheWeek'] . "</td>";
                                    echo "<td>" . $row['midterm1'] . "</td>";
                                    echo "<td>" . $row['midterm2'] . "</td>";
                                    echo "<td>" . $row['midterm3'] . "</td>";
                                    echo "</tr>";
                                }
                                mysqli_free_result($query);
                                mysqli_free_result($result);
                            ?>
							</tbody>
							</table>

						</div>
						
						
						
						
					</div>
	            </div>
	        </div>
	    </div>
	    <div class="form-group row" style="margin-bottom: 100px">
					<div class="col-sm-8" style="margin-left: 100px">
						<button id="submit" type="submit" class="btn btn-outline-primary">SUBMIT</button>
					</div>
					<script type="text/javascript">
					
					    // put data to database
						$('#submit').on('click', function (e) {
							//do nothing
							var netid = document.getElementById("username").value;
							for (var i=0; i<=next; i++){
								var name = 'action_id' + i;
							    var query = document.getElementById(name).value;
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
							}
						})
						
						// only one box is checked
						$(document).ready(function(){
                            $('input:checkbox').click(function() {
                                $('input:checkbox').not(this).prop('checked', false);
                            });
                        });
                        
                        var table = $('#course').DataTable();
                        $('#course tbody').on( 'click', '.checkbox', function() {
                        if(this.checked==true)
                        {
                        console.log( table.row( this.closest('tr') ).data() );
                        }
                        } );
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