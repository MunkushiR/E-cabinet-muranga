<?php 
include('db_connect.php');

// Initialize $meta as an empty array
$meta = array();

if(isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input
    $user = $conn->query("SELECT * FROM employees WHERE id = $id");

    if ($user && $user->num_rows > 0) {
        $meta = $user->fetch_assoc(); // Fetch associative array
    } else {
        // Handle case where no user was found
        echo "No employee found with the given ID.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
</head>
<body>
    <div class="container-fluid mt-4">
        <form action="" id="manage-employee">
            <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? htmlspecialchars($meta['id']) : ''; ?>">
            
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? htmlspecialchars($meta['firstname']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? htmlspecialchars($meta['lastname']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="personal_number">Persoanl Number</label>
                <input type="text" name="personal_number" id="personal_number" class="form-control" value="<?php echo isset($meta['personal_number']) ? htmlspecialchars($meta['personal_number']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="position">Position</label>
                <select class="custom-select" name="position" id="position">
                    <?php
                    $depts = $conn->query("SELECT name FROM members ORDER BY name ASC");
                    while ($deptRow = $depts->fetch_assoc()) {
                        $selected = (isset($meta['name']) && $meta['name'] == $deptRow['name']) ? 'selected' : '';
                        echo "<option value='{$deptRow['name']}' $selected>{$deptRow['name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="work_email">Work Email</label>
                <input type="email" name="work_email" id="work_email" class="form-control" value="<?php echo isset($meta['work_email']) ? htmlspecialchars($meta['work_email']) : ''; ?>" required>
            </div>

            <div class="form-group">
                <label for="phonenumber">Phone Number</label>
                <input type="text" name="phonenumber" id="phonenumber" class="form-control" value="<?php echo isset($meta['phonenumber']) ? htmlspecialchars($meta['phonenumber']) : ''; ?>" required>
            </div>

			<div class="form-group">
                <label for="national_id">National_Id</label>
                <input type="int" name="national_id" id="national_id" class="form-control" value="<?php echo isset($meta['national_id']) ? htmlspecialchars($meta['national_id']) : ''; ?>" required>
            </div>
        </form>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#manage-employee').submit(function(e) {
                e.preventDefault();
                start_load();
                $.ajax({
                    url: 'ajax.php?action=save_employee',
                    method: 'POST',
                    data: new FormData(this),
                    processData: false,
                    contentType: false,
                    success: function(resp) {
                        if (resp == 1) {
                            alert_toast("Data successfully saved", 'success');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        } else {
                            alert_toast("An error occurred while saving data", 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert_toast("AJAX error: " + textStatus, 'error');
                    }
                });
            });
        });

        function start_load() {
            // Implement loader if you have one
            console.log('Loading...');
        }

        function alert_toast(message, type) {
            // Implement toast notification if you have one
            alert(type + ": " + message);
        }
    </script>
</body>
</html>
