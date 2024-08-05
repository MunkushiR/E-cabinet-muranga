<?php 
include('./header.php'); 
include('./db_connect.php'); 
	   
       // Check connection
       if($conn === false){
        die("ERROR: Could not connect. " 
            . mysqli_connect_error());
    }	
    $type = $_REQUEST['type'];
    $date = $_REQUEST['date'];
    $time = $_REQUEST['time'];
    $agenda = $_REQUEST['agenda'];
    $absent = $_REQUEST['absent']; 
    $attendees = $_REQUEST['attendees']; 
    $content = $_REQUEST['content']; 
    $file = $_REQUEST['file']; 
	
	
		// Performing insert query execution
		// here our table name is college
        $sql = "INSERT INTO `meetings`(`type`, `date`, `time`, `agenda`, `absent`, `attendees`, `content`, `file`) 
        VALUES ('$type','$date' , '$time' , '$agenda', '$absent', '$attendees' , '$content', '$file')";
        if (mysqli_query($conn, $sql)) {
           header("location:sentsuccess.php");
        } else {
           echo "Error: " . $sql . "
   " . mysqli_error($conn);
        }
        mysqli_close($conn);
   ?>
   