<?php 
include('db_connect.php');
session_start(); // Ensure the session is started

if(isset($_GET['id'])){
    $user = $conn->query("SELECT * FROM meetings WHERE id = ".$_GET['id']);
    if($user->num_rows > 0){
        $meta = $user->fetch_assoc();
    } else {
        echo "No meeting found with the given ID.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Meeting</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Include CKEditor -->
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>
<body>
<div class="container-fluid">
    <form action="" id="manage-meeting" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id'] : '' ?>">
        <div class="form-group">
            <label for="type" class="control-label">Meeting Type</label>
            <select class="custom-select browser-default select2" name="type" id="type">
                <?php
                $types = $conn->query("SELECT DISTINCT name FROM department ORDER BY name ASC");
                while ($typeRow = $types->fetch_assoc()) {
                    $selected = (isset($meta['type']) && $meta['type'] == $typeRow['name']) ? 'selected' : '';
                    echo "<option value='{$typeRow['name']}' $selected>{$typeRow['name']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="title">Meeting title</label>
            <input type="text" name="title" id="title" class="form-control" value="<?php echo isset($meta['title']) ? htmlspecialchars($meta['title']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" name="date" id="date" class="form-control" value="<?php echo isset($meta['date']) ? $meta['date'] : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" name="time" id="time" class="form-control" value="<?php echo isset($meta['time']) ? date('H:i', strtotime($meta['time'])) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="present_members">Select Members Present:</label>
            <textarea name="present_members" id="present_members" class="form-control" rows="3" required><?php echo isset($meta['present_members']) ? htmlspecialchars($meta['present_members']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="attendees">In attendance</label>
            <textarea name="attendees" id="attendees" class="form-control" rows="3" required><?php echo isset($meta['attendees']) ? htmlspecialchars($meta['attendees']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="absent">Absent with Apology</label>
            <textarea name="absent" id="absent" class="form-control" rows="3" required><?php echo isset($meta['absent']) ? htmlspecialchars($meta['absent']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="agenda">Agenda</label>
            <textarea name="agenda" id="agenda" class="form-control" rows="4" required><?php echo isset($meta['agenda']) ? htmlspecialchars($meta['agenda']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" id="content" class="form-control" rows="4" required><?php echo isset($meta['content']) ? htmlspecialchars($meta['content']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="signed_by">Signed By</label>
            <input type="text" name="signed_by" id="signed_by" class="form-control" value="<?php echo isset($meta['signed_by']) ? htmlspecialchars($meta['signed_by']) : ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="file">Upload File:</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>
   
    </form>
</div>

<script>
  $(document).ready(function() {
    // Initialize CKEditor for textareas

    CKEDITOR.replace('present_members');
    CKEDITOR.replace('attendees');
    CKEDITOR.replace('absent');
    CKEDITOR.replace('agenda');
    CKEDITOR.replace('content');

    $('#manage-meeting').submit(function(e) {
        e.preventDefault();

        // Update all CKEditor instances before form submission
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }

        // Start the loading function
        start_load();

        // Send form data via AJAX
        $.ajax({
            url: 'ajax.php?action=save_meeting',
            method: 'POST',
            data: new FormData(this), // Ensure CKEditor data is now part of form data
            processData: false,
            contentType: false,
            success: function(resp) {
                // Check if response is valid JSON
                try {
                    var response = JSON.parse(resp);

                    if (response.status == 1) {
                        alert_toast(response.message, 'success');
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    } else {
                        alert_toast("Error: " + (response.message || "Unknown error"), 'error');
                    }
                } catch (e) {
                    // If JSON parsing fails, show the raw response for debugging
                    alert_toast("Error: Invalid server response. " + resp, 'error');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert_toast("AJAX error: " + textStatus + " - " + errorThrown, 'error');
            }
        });
    });
});


    function start_load() {
        console.log('Loading...');
    }

    function alert_toast(message, type) {
        alert(type + ": " + message);
    }
</script>
</body>
</html>
