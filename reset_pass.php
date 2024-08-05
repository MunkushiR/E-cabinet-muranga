<!DOCTYPE html>
<html>
<?php require_once "controllerUserData.php"; ?>
<style>
body {
    background: url(assets/img/payroll-cover.jpg);
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100vh;
	flex-direction: column;
}

*{
	font-family: sans-serif;
	box-sizing: border-box;
}

form {
	width: 500px;
	border: 2px solid #ccc;
	padding: 30px;
	background: #fff;
	border-radius: 15px;
}

h2 {
	text-align: center;
	margin-bottom: 40px;
    color:black;
}

input {
	display: block;
	border: 2px solid #ccc;
	width: 95%;
	padding: 10px;
	margin: 10px auto;
	border-radius: 5px;
}
label {
	color: #888;
	font-size: 18px;
	padding: 10px;
}

button {
	float: right;
	background: #555;
	padding: 10px 15px;
	color: #fff;
	border-radius: 5px;
	margin-right: 10px;
	border: none;
}
button:hover{
	opacity: .7;
}
.error {
   background: #F2DEDE;
   color: #A94442;
   padding: 10px;
   width: 95%;
   border-radius: 5px;
   margin: 20px auto;
}

.success {
   background: #D4EDDA;
   color: #40754C;
   padding: 10px;
   width: 95%;
   border-radius: 5px;
   margin: 20px auto;
}

h1 {
	text-align: center;
	color: #fff;
}

.ca {
	font-size: 14px;
	display: inline-block;
	padding: 10px;
	text-decoration: none;
	color: #444;
}
.ca:hover {
	text-decoration: underline;
} 

.home-nav a {
	padding: 10px;
	color: #f7bd65;
	text-transform: uppercase;
	text-decoration: none;
}
</style>
<head>
	<title>Forgot Password</title>
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form">
                <form action="passwordsendrequest.php" method="POST" autocomplete="">
                    <h2 class="text-center">Forgot Password</h2>
                    <center><p>please enter your username  and Email you used to sign up
					on this site and we will assist you in recovering your password</p></center>
                    <?php
                        if(count($errors) > 0): ?>
                           <div class="alert alert-danger">
                                <?php 
                                    foreach($errors as $error):?>
									<li><?php echo $error; ?></li>
                                      <?php endforeach; ?>     
                            </div>
                            <?php endif; ?>
							<div class="form-group">
                        <input class="form-control" type="text" name="work_id" placeholder="Enter your work_id" required value="<?php echo $email ?>">
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="submit_username" value="Recover your password">
                    </div>
                </form>
            </div>
        </div>
    </div>
    
</body>
</html>