<?php
include('db_connect.php');

// Get the current user's position
session_start(); // Start session to access session variables
$currentUserId = $_SESSION['personal_number'];
$positionQuery = $conn->query("
    SELECT position 
    FROM employees 
    WHERE personal_number = '$currentUserId'
");
$positionRow = $positionQuery->fetch_assoc();
$currentPosition = $positionRow['position'];

// Fetch all meetings
$meetingsQuery = $conn->query("
    SELECT * 
    FROM minutes
");

// Initialize the list of meetings to display
$meetingsToDisplay = [];

// Positions that can view all meetings
$positionsWithFullAccess = ['Governor', 'Deputy Governor'];

while ($meeting = $meetingsQuery->fetch_assoc()) {
    // Split the comma-separated attendees string into an array
    $attendeesArray = explode(', ', $meeting['attendees']);
    
    // Check if the current position is in the list of attendees or has full access
    if (in_array($currentPosition, $attendeesArray) || in_array($currentPosition, $positionsWithFullAccess)) {
        $meetingsToDisplay[] = $meeting;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meetings</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMD4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style>
        .card {
            margin: 20px;
        }
        select {
            width: 100%;
            height: 40px;
            border: 1px grey;
            border-radius: .5px;
            box-shadow: 1px 1px 2px 1px darkgrey;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <?php if (!empty($meetingsToDisplay)): ?>
                    <table id="table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Date</th>
                                <th class="text-center">Time</th>
                                <th class="text-center">Location</th>
                                <th class="text-center">Agenda</th>
                                <th class="text-center">Minutes of the Meeting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($meetingsToDisplay as $meeting):
                            ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo htmlspecialchars($meeting['type']); ?></td>
                                    <td><?php echo htmlspecialchars($meeting['date']); ?></td>
                                    <td>
                                        <?php
                                        // Format time to 12-hour format with AM/PM
                                        $time = new DateTime($meeting['time']);
                                        echo $time->format('h:i A');
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($meeting['location']); ?></td>
                                    <td><?php echo htmlspecialchars($meeting['agenda']); ?></td> <!-- Display the agenda -->
                                    <td>
                                        <?php if (!empty($meeting['file'])): ?>
                                            <a href="<?php echo htmlspecialchars($meeting['file']); ?>" target="_blank">View/Download Document</a>
                                        <?php else: ?>
                                            No document found
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-warning" role="alert">
                        No meetings found for your position.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            // jQuery click event handler for mark as read button
            $('.mark-read').click(function(){
                var id = $(this).data('id');
                // Send AJAX request to mark the message as read or unread
                $.ajax({
                    url: 'mark_as_read.php',
                    type: 'POST',
                    data: { id: id },
                    success: function(response){
                        // Reload the page after successful marking
                        location.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>
