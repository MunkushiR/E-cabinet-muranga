<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <style>
        .card-body {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <?php include('db_connect.php'); ?>

    <div class="container">
        <div class="card">
            <div class="card-header">
                Notifications
            </div>
            <div class="card-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $advance_qry = $conn->query("SELECT * FROM `notifications`") or die(mysqli_error($conn));
                        while ($row = $advance_qry->fetch_array()) {
                            $modalId = 'replyModal' . $row['id']; // Unique ID for each modal
                        ?>
                        <tr>
                            <td>
                                <h5>Subject:</h5><b><?php echo htmlspecialchars($row['Subject']); ?></b>
                                <br><br><h5>Message:</h5><?php echo htmlspecialchars($row['Message']); ?>
                            </td>
                            <td>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#<?php echo $modalId; ?>">
                                    Reply
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="replyModalLabel">Reply to Notifications</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="reply.php" method="POST">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="subject">Subject</label>
                                                        <input type="text" id="subject" name="subject" required class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="message">Message</label>
                                                        <input type="text" id="message" name="message" required class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="from">From</label>
                                                        <input type="text" id="from" name="from" required class="form-control">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="date">Date</label>
                                                        <input type="date" id="date" name="date" required class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Send</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
