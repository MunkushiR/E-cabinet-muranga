<?php 
include('./header.php'); 
include('./db_connect.php'); 
	   
       // Check connection
       if($conn === false){
        die("ERROR: Could not connect. " 
            . mysqli_connect_error());
    }	
    $subject = $_REQUEST['subject'];
    $message = $_REQUEST['message'];
    $from = $_REQUEST['from'];
    $date = $_REQUEST['date']; 
    $date = $_REQUEST['date']; 
	
		// Performing insert query execution
		// here our table name is college
        $sql = "INSERT INTO `message`(`subject`, `message`, `from`, `date`) 
        VALUES ('$subject','$message' , '$from' , '$date')";
        if (mysqli_query($conn, $sql)) {
           header("location:sentsuccess.php");
        } else {
           echo "Error: " . $sql . "
   " . mysqli_error($conn);
        }
        mysqli_close($conn);
   ?>
   