<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width"/>
<title>ECABINET MURANG'A</title>
<link rel="manifest" href="manifest.json">
<link rel="stylesheet" href="stylesheets/skins/blue.css">
<link rel="stylesheet" href="stylesheets/responsive.css">
</head>
<style>
.message_box {
  width: 500px;
}
</style>
<body>
<div class="container">
  <div class="jumbutton">
    <h3>Send Notifications to Users</h3>
    <hr>
    <div class="row">
      <div class="col-md-6">
        <form action="sendmessage.php" method="POST">
          <div class="form-group">
            <label for="subject">Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Enter your subject">
          </div>
          <div class="form-group">
            <label for="message">Message</label>
            <textarea class="form-control" id="message" name="message" cols="20" rows="10"></textarea>
          </div>
          <div class="form-group">
            <label for="from">From</label>
            <input type="text" class="form-control" id="from" name="from" placeholder="Enter sender's name">
          </div>
          <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" id="date" name="date">
          </div>
          <div class="form-group">
            <label for="method">Send via</label>
            <select class="form-control" id="method" name="method">
              <option value="email">Email</option>
              <option value="sms">SMS</option>
              <option value="whatsapp">WhatsApp</option>
            </select>
          </div>
          <div class="form-group">
            <label for="recipient">Recipient</label>
            <input type="text" class="form-control" id="recipient" name="recipient" placeholder="Enter recipient's email or phone number">
          </div>
          <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</div>
</body>   
</html>
