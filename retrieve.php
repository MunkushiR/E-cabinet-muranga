<?php
session_start();
include ('db_connect.php');

if(isset($_POST['personal_number']) && isset($_POST['national_id'])){
    $personal_number = $_POST['personal_number'];
    $national_id = $_POST['national_id'];
   

    if (empty($personal_number)) {
      header("location:stafflogin.php?error=personal_number is required"); 
    }elseif (empty($national_id)) {
      header("location:stafflogin.php?error=Id is required");  
    }else {
      header("location:stafflogin.php?error=Invalid Id or personal_number");
    }
   
  }
    //$password = MD5($password);
    $sql = "SELECT * FROM employees WHERE personal_number='$personal_number' AND national_id='$national_id'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) === 1)
    {
      $row=mysqli_fetch_assoc($result);  
        
       if ($row['personal_number']===$personal_number && $row['national_id'] === $national_id ) {
        $_SESSION['id'] = $row['id'];
        $_SESSION['personal_number'] = $row['personal_number'];
          header("Location:employeehome.php");
          exit();
       }
       else
       {
           header("Location:stafflogin.php.php?failed=invalid Id or personal_number");
	        exit();
       exit();
           echo $conn->error;
       }
    }
  

?>