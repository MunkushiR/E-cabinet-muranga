<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <link rel="shortcut icon" type="image/ico" href="assets/img/logo.png" />
  <title>ECABINET MURANGA</title>
 	
<?php 
session_start();
include('./header.php'); 
include('./db_connect.php'); 
?>

</head>
<style>
	body{
		width: 100%;
	    height: calc(100%);
	    background: #007bff;
	}
	main#main{
		width:100%;
		height: calc(100%);
		background:white;
	}
	#login-right{
		position: absolute;
		right:0;
		width:40%;
		height: calc(100%);
		background:white;
		background: url(assets/img/register.jpg);
		display: flex;
		align-items: center;
	}
	#login-left{
		position: absolute;
		left:0;
		width:60%;
		height: calc(100%);
		background:#59b6ec61;
		display: flex;
		align-items: center;
		background: url(assets/img/register.jpg);
	    background-repeat: no-repeat;
	    background-size: cover;
	}
	#login-right .card{
		margin: auto;
		z-index: 1
	}
	.logo {
    margin: auto;
    font-size: 8rem;
    background: white;
    padding: .5em 0.7em;
    border-radius: 50% 50%;
    color: #000000b3;
    z-index: 10;
}
div#login-right::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: calc(100%);
    height: calc(100%);
    background: #9fa3a7e0;
}
.card-body h4{
	background: #9fa3a7e0;
	text-align: center;
	style: bold;
}
</style>

<body>
  <main id="main" class=" bg-dark">
  		<div id="login-left">
  			
  		</div>
  		<div id="login-right">
  			<div class="card col-md-8">
  				<div class="card-body">
				  <center><img src="assets/img/logo.png" alt=" logo" style="width:150px;height:150px;"></center>
				  <h4>STAFF LOGIN</h4>
				  <?php if(isset($_GET['error'])){ ?>
				  <div class ="alert alert-danger" roler="alert">
					  <?php echo $_GET['error'];?>
					</div>
				  <?php } ?>
				  <form action="retrieve.php" method="POST">
  					<form id="employee_login-form" >
					  <div class="form-group">
  							<label for="personal_number" class="control-label">Personal Number</label>
  							<input type="phone" id="personal_number" name="personal_number" value=""   class="form-control">
  						</div>
  						<div class="form-group">
  							<label for="work_id" class="control-label">ID</label>
  							<input type="text" id="national_id" name="national_id" value=""  class="form-control">
  						</div>
  						<center><button name="submit" class="btn-sm btn-block btn-wave col-md-4 btn-primary">Login</button></center>
  					</form>
					 
					  <div class="text-center">
                                       
                                    </div>
  				</div>
  				</div>
  			</div>
  		</div>
				

  </main>

  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

</body>
	
</html>
<!--  -->