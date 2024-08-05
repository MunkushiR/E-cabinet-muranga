<?php 

?>

<div class="container-fluid">
	
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_meeting"><i class="fa fa-plus"></i> New Minutes</button>
	</div>
	</div>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
			<table id="table" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>#</th>
									<th>Meeting Type</th>
									<th>Meeting Title</th>
                                    <th>Date and Time</th>
                                    <th>Present Members</th>
									<th>Agenda</th>
									<th>Absent with apology</th>
									<th>In Attendance</th>
                                    <th>Content</th>
									<th>Signed by</th>
									<th>Uploads</th>
                                     <th>Action</th>
								</tr>
							</thead>
			<tbody>
				<?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM meetings");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 <td>
				 		<?php echo $i++ ?>
				 	</td>
							<td><?php echo $row['type'];?>
						</td>
						<td><?php echo $row['title'];?></td>
                            <td>
							<?php echo $row['date'];?></b>
                            
    <?php
    // Assuming $row['time'] contains the time in a format like 'HH:MM:SS'
    $time = $row['time'];

    // Create a DateTime object from the time string
    $dateTime = new DateTime($time);

    // Format the time to 12-hour format with AM/PM
    echo $dateTime->format('h:i A');
    ?>
						</td>
						
							<td><?php echo $row['present_members'];?></td>
							<td><?php echo $row['agenda'];?></td>
							<td><?php echo $row['absent'];?></td>
							<td><?php echo $row['attendees'];?></td>
                            <td><?php echo $row['content'];?></td>
							<td><?php echo $row['signed_by'];?></td>
							<td>
    <?php if (!empty($row['file'])): ?>
        <a href="<?php echo $row['file']; ?>" target="_blank">View/Download Document</a>
    <?php else: ?>
        No document available
    <?php endif; ?>
</td>



				 	<td>
				 		<center>
								<div class="btn-group">
								  <button type="button" class="btn btn-primary">Action</button>
								  <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								    <span class="sr-only">Toggle Dropdown</span>
								  </button>
								  <div class="dropdown-menu">
								    <a class="dropdown-item edit_meeting" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_meeting" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
								  </div>
								  <a href="meeting_pdf.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success "><i class="fa fa-book"></i></a>
								</div>
								</center>
				 	</td>
				 </tr>
				<?php endwhile; ?>
			</tbody>
		</table>
			</div>
		</div>
	</div>

</div>
<script>
	
$('#new_meeting').click(function(){
	uni_modal('New Minutes','manage_meeting.php')
})
$('.edit_meeting').click(function(){
	uni_modal('Edit Meeting','manage_meeting.php?id='+$(this).attr('data-id'))
})
$('.delete_meeting').click(function(){
		_conf("Are you sure to delete this Minute?","delete_meeting",[$(this).attr('data-id')])
	})
	function delete_meeting($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_meeting',
			method:'POST',
			data:{id:$id},
			success:function(resp){
				if(resp==1){
					alert_toast("Data successfully deleted",'success')
					setTimeout(function(){
						location.reload()
					},1500)

				}
			}
		})
	}
</script>