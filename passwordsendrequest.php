<?php 

session_start();
include('./db_connect.php'); 
include('./header.php'); 
	   
        // Check connection
        if($conn === false){
            die("ERROR: Could not connect. " 
                . mysqli_connect_error());
        }
		
		$work_id = $_REQUEST['work_id'];
	
		

        $sql = "INSERT INTO `password_reset`(`work_id`) 
        VALUES ('$work_id')";
        if (mysqli_query($conn, $sql)) {
            header("location:passwordresetsuccess.php");
        }  else{
            echo"Error: ".$sql;
        }
		
		// Close connection
		mysqli_close($conn);
		?>