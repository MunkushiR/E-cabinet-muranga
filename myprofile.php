<?php
include "db_connect.php";

if (isset($_POST['update'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $personal_number = mysqli_real_escape_string($conn, $_POST['personal_number']);
    $work_email = mysqli_real_escape_string($conn, $_POST['work_email']);
    $phonenumber = mysqli_real_escape_string($conn, $_POST['phonenumber']);
    $national_id = mysqli_real_escape_string($conn, $_POST['national_id']);
    $currentUser = $_SESSION['personal_number'];
    
    // Update SQL query without the position field
    $sql = "UPDATE `employees` SET `firstname`='$firstname', `lastname`='$lastname', `personal_number`='$personal_number',
    `work_email`='$work_email', `phonenumber`='$phonenumber', `national_id`='$national_id' WHERE `personal_number`='$currentUser'";
    
    $result = $conn->query($sql);
    if ($result) {
        echo "<center><button><b>Record updated successfully.</b></button></center>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile | ECABINET MURANG'A</title>
    <style>
        .card {
            width: 605px;
        }
        .card-heading {
            font-size: 30px;
            color: #3297FD;
            text-align: center;
            padding-top: 10px;
        }
        select {
            width: 100%;
            height: 40px;
            border: 1px light-grey;
            border-radius: .5px;
            box-shadow: 1px 1px 2px 1px grey;
        }
    </style>
</head>
<body>
    <?php include 'db_connect.php'; ?>
    <?php include './header.php'; ?>

    <div class="divider"></div>
    <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card">
                <div class="card-heading">
                    <h2 class="title">My Profile</h2>
                </div>
                <div class="card-body">
                    <?php
                    $currentUser = $_SESSION['personal_number'];
                    $sql = "SELECT * FROM `employees` WHERE `personal_number` = '$currentUser'";
                    $gotResults = mysqli_query($conn, $sql);
                    if ($gotResults && mysqli_num_rows($gotResults) > 0) {
                        $row = mysqli_fetch_array($gotResults);
                    ?>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="firstname" class="control-label">Firstname</label>
                            <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="lastname" class="control-label">Lastname</label>
                            <input type="text" id="lastname" name="lastname" value="<?php echo $row['lastname']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="personal_number" class="control-label">Personal Number</label>
                            <input type="text" id="personal_number" name="personal_number" value="<?php echo $row['personal_number']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="work_email" class="control-label">Work Email</label>
                            <input type="email" id="work_email" name="work_email" value="<?php echo $row['work_email']; ?>" class="form-control">
                        </div>
                        <!-- Removed Position Field -->
                        <div class="form-group">
                            <label for="phonenumber" class="control-label">Phone Number</label>
                            <input type="tel" id="phonenumber" name="phonenumber" value="<?php echo $row['phonenumber']; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="national_id" class="control-label">National ID</label>
                            <input type="text" id="national_id" name="national_id" value="<?php echo $row['national_id']; ?>" class="form-control">
                        </div>
                        <center>
                            <button type="submit" class="btn-sm btn-block btn-wave col-md-4 btn-primary" value="Update" name="update">Update Profile</button>
                        </center>
                    </form>
                    <?php
                    } else {
                        echo "No user found.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
