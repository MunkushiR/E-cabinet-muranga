<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit SMS</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- Add SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- Add SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
</head>

<body>
<div class="container">
  <div class="jumbutton">
    <h3>Send Notifications to Users</h3>
    <hr>
    <div class="row">
      <div class="col-md-6">
        <!-- Display success or error messages -->
        <div id="alert-container">
          <?php if (isset($success_message) && !empty($success_message)): ?>
            <div class="alert alert-success">
              <?php echo $success_message; ?>
            </div>
          <?php endif; ?>
          <?php if (isset($error_message) && !empty($error_message)): ?>
            <div class="alert alert-danger">
              <?php echo $error_message; ?>
            </div>
          <?php endif; ?>
        </div>

        <form id="manage-sms" method="POST">
          <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter your subject">
          </div>
          <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date">
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" name="message" cols="20" rows="10"></textarea>
          </div>
          <div class="form-group">
            <label for="recipient">Recipient(s)</label>
            <input type="text" class="form-control" id="recipient" name="recipient" placeholder="Enter recipient's phone numbers separated by commas (e.g., +254712345678, +254712345679)">
          </div>
          <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function() {
        $('#manage-sms').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: 'sendmessage.php',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    console.log('Response:', response); // Debug response

                    try {
                        var jsonResponse = JSON.parse(response);

                        if (jsonResponse.status === 'success') {
                            // Show success message popup
                            Swal.fire({
                                title: 'Success!',
                                text: jsonResponse.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            // Show error message popup
                            Swal.fire({
                                title: 'Error!',
                                text: jsonResponse.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    } catch (e) {
                        // Show parsing error message popup
                        Swal.fire({
                            title: 'Error!',
                            text: 'Error parsing server response: ' + e.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // Show AJAX error message popup
                    Swal.fire({
                        title: 'AJAX Error!',
                        text: 'AJAX error: ' + textStatus + ' - ' + errorThrown,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>

</body>
</html>
