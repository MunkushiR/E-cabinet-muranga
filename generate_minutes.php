<?php 
include('./header.php'); 
include('./db_connect.php'); 
	   
       // Check connection
       if($conn === false){
        die("ERROR: Could not connect. " 
            . mysqli_connect_error());
    }	
    $title = $_REQUEST['title'];
    $date = $_REQUEST['date'];
    $prepared = $_REQUEST['prepared'];
    $location= $_REQUEST['location'];
    $time = $_REQUEST['time'];
    $purpose = $_REQUEST['purpose']; 
    $attendance = $_REQUEST['attendance']; 
    $absent = $_REQUEST['absent'];
    $content = $_REQUEST['content']; 
    $next = $_REQUEST['next']; 
	
	
	
		// Performing insert query execution
		// here our table name is college
        $sql = "INSERT INTO `minutes`(`title`, `date`, `prepared`, `location`, `time`, `purpose`, `attendance`, `absent`, `content`, `next`) 
        VALUES ('$title','$date' , '$prepared' , '$location', '$time','$purpose','$attendance' , '$absent' , '$content', '$next')";
        if (mysqli_query($conn, $sql)) {
           header("location:sentsuccess.php");
        } else {
           echo "Error: " . $sql . "
   " . mysqli_error($conn);
        }
        mysqli_close($conn);
   ?>
   