<?php 
include('db_connect.php');
if(isset($_GET['id'])){
    $meeting = $conn->query("SELECT * FROM minutes WHERE id = " . intval($_GET['id']));
    if($meeting->num_rows > 0){
        $meta = $meeting->fetch_assoc();
    } else {
        echo "No minutes found with the given ID.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Minutes</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</head>
<body>
<div class="container-fluid">
    <form action="" id="manage-minutes" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo isset($meta['id']) ? htmlspecialchars($meta['id']) : '' ?>">
        <div class="form-group">
            <label for="type" class="control-label">Meeting Type</label>
            <select class="custom-select browser-default select2" name="type" id="type" required>
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
            <label>Date of Meeting</label>
            <input type="date" name="date" id="date" class="form-control" value="<?php echo isset($meta['date']) ? htmlspecialchars($meta['date']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="time">Time</label>
            <input type="time" name="time" id="time" class="form-control" value="<?php echo isset($meta['time']) ? htmlspecialchars($meta['time']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label>Location</label>
            <input type="text" name="location" id="location" class="form-control" value="<?php echo isset($meta['location']) ? htmlspecialchars($meta['location']) : '' ?>" required>
        </div>
        <div class="form-group">
            <label for="attendees">Those to attend</label>
            <select class="custom-select browser-default select2" name="attendees[]" id="attendees" multiple required>
                <?php
                $positions = $conn->query("SELECT DISTINCT position FROM employees ORDER BY position ASC");
                while ($positionRow = $positions->fetch_assoc()) {
                    $selected = (isset($meta['attendees']) && in_array($positionRow['position'], explode(', ', $meta['attendees']))) ? 'selected' : '';
                    echo "<option value='{$positionRow['position']}' $selected>{$positionRow['position']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Agenda</label>
            <textarea name="agenda" id="agenda" class="form-control" required><?php echo isset($meta['agenda']) ? htmlspecialchars($meta['agenda']) : '' ?></textarea>
        </div>
        <div class="form-group">
            <label for="file">Upload File:</label>
            <input type="file" name="file" id="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
<script>
    $(document).ready(function() {
        $('#manage-minutes').submit(function(e) {
            e.preventDefault();
            start_load();
            $.ajax({
                url: 'ajax.php?action=save_minutes',
                method: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Minutes successfully saved", 'success');
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
        console.log('Loading...');
    }

    function alert_toast(message, type) {
        alert(type + ": " + message);
    }
</script>
</body>
</html>
