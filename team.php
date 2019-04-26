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
                <a class="nav-link" href="http://toptripplanner.web.illinois.edu">QUICK START</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">TEAM<span class="sr-only">(current)</span></a>
              </li>
            </ul>
          </div>
        </nav>
	    
		<div class="box">
    <div class="container">
     	<div class="row">
			 
			    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               
					<div class="box-part text-center">
                        
                        <i class="fa fa-instagram fa-3x" aria-hidden="true"></i>
                        
						<div class="title">
							<h4>Michael Chang</h4>
						</div>
                        
						<div class="text">
							<span>Email: mchang19@illinois.edu</span>
						</div>
                        
					 </div>
				</div>	 
				
				 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               
					<div class="box-part text-center">
					    
					    <i class="fa fa-twitter fa-3x" aria-hidden="true"></i>
                    
						<div class="title">
							<h4>Di Ye</h4>
						</div>
                        
						<div class="text">
							<span>Email: diye2@illinois.edu</span>
						</div>
					 </div>
				</div>	 
				
				 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               
					<div class="box-part text-center">
                        
                        <i class="fa fa-facebook fa-3x" aria-hidden="true"></i>
                        
						<div class="title">
							<h4>Leo Zhao</h4>
						</div>
                        
						<div class="text">
							<span>Email: cz28@illinois.edu</span>
						</div>
					 </div>
				</div>	 
				
				<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
               
					<div class="box-part text-center">
                        
                        <i class="fa fa-pinterest-p fa-3x" aria-hidden="true"></i>
                        
						<div class="title">
							<h4>Ruixi Zhang</h4>
						</div>
                        
						<div class="text">
							<span>Email: rzhang76@illinois.edu</span>
						</div>
					 </div>
				</div>	 
		</div>		
    </div>
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