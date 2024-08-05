<?php 
session_start();
    include "db_connect.php";
    $errors = array();
    $email = "";
    $username = "";
    //if user clicks the forgot password button
    if(isset($_POST['check-email'])){
        $email = $_POST['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $errors['email'] = "Email address is invalid" ; 
        }
        if(empty($email)){
            $errors['email'] = "email required";
        }
        if (count($errors)==0) {
           $sql = "SELECT * FROM `patientregister` WHERE  email=$'email' LIMIT 1 ";
           $result = mysqli_query($conn,$sql);
           $user = mysqli_fetch_assoc($result);
           $token = $user['token'];
           sendPasswordResetLink($email,$token);
           header('location:passwordmessage');
           exit(0);
        
        }
    }