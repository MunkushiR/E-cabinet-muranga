<!DOCTYPE html>
<html lang = "en">
<head>
</head>
<body>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
.card{
    padding-left:-160px;
    margin-left:-30px;
}
select{
	width:100%;
	height:40px;
	border:1px 	grey;
	border-radius: .5px;
	box-shadow: 1px 1px 2px 1px darkgrey;
}
</style>
<?php include('db_connect.php') ?>
		<div class="container-fluid " >
			<div class="col-lg-12">
				<br />
				<br />
				<div class="card">
					<div class="card-header">
                      <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#newmeeting">
  Add Minutes
</button>

<!-- Modal -->
<div class="modal fade" id="newmeeting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add New Minutes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form action="meetingdata.php" method="POST">
      <div class="modal-body">
      <select class="custom-select browser-default select2" name="type" id="type">
            <option value=""></option>
            <?php
            $dept = $conn->query("SELECT * from department order by name asc");
            while($row = $dept->fetch_assoc()):
            ?>
                <option value="<?php echo $row['name'] ?>" <?php echo isset($type) && $type == $row['type'] ? "selected" : "" ?>><?php echo $row['name'] ?></option>
            <?php endwhile; ?>
        </select>
		<div class="form-group">
			<label>Date:</label>
			<input type="date" name="date" id="date" required="required" class="form-control" value="<?php echo isset($date) ? $date : "" ?>" />
		</div>
		<div class="form-group">
			<label>Time</label>
			<input type="time" name="time" id="time" required="required" class="form-control" value="<?php echo isset($time) ? $time : "" ?>" />
		</div>
		<div class="form-group">
			<label>Content</label>
			<input type="text" name ="content" id="content" placeholder="required" class="form-control" value="<?php echo isset($content) ? $content : "" ?>" />
		</div>
        <div class="form-group">
        <label for="file">Upload File:</label>
        <input type="file" name="file" id="file" class="form-control" >
    </div>
  					</form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="save" class="btn btn-primary">Send</button>
      </div>
    </div>
  </div>
</div>
</div>
					
						<table id="table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Id</th>
                                    <th>Type</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Content</th>
                                    <th>File</th>
                                
								</tr>
							</thead>
							<tbody>
							<?php
			
				$sql ="SELECT * FROM `meetings`";
				$gotResults = mysqli_query($conn,$sql);
				if($gotResults){
					if(mysqli_num_rows($gotResults)>0){
						while ($row = mysqli_fetch_array($gotResults)) {
					
							//print_r($row['firstname']);
									
								?>
							<tr>
                            <td><?php echo $row['id'];?></td>
                            <td><?php echo $row['type'];?></td>
                            <td><?php echo $row['date'];?></td>
                            <td><?php echo $row['time'];?></td>
                            <td><?php echo $row['content'];?></td>
                            <td>
                    <?php
                    $file = $row['file'];
                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

                    if (in_array(strtolower($fileExtension), ['pdf', 'doc', 'docx', 'txt'])) {
                        // If the file is a PDF, Word document, or text file, display it using Google Docs Viewer
                        echo "<a href='https://docs.google.com/viewer?url=" . urlencode($file) . "' target='_blank'>View Document</a>";
                    } else {
                        // For other file types, provide a direct download link
                        echo "<a href='" . $file . "' target='_blank'>Download File</a>";
                    }
                    ?>
                </td>
                            
								<?php
									}
								}
							}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		</body>	
		</html>
		</script>
