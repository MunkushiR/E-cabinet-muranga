<?php 

?>

<div class="container-fluid">
	
	<div class="row">
	<div class="col-lg-12">
			<button class="btn btn-primary float-right btn-sm" id="new_minute"><i class="fa fa-plus"></i> New Meeting</button>
	</div>
	</div>
	<br>
	<div class="row">
		<div class="card col-lg-12">
			<div class="card-body">
				<table class="table-striped table-bordered col-md-12">
			<thead>
				<tr>
					<th class="text-center">#</th>
                    <th class="text-center">Type</th>
					<th class="text-center">Date</th>
					<th class="text-center">Time</th>
                    <th class="text-center">Location</th>
                    <th class="text-center">members</th>
					<th class="text-center">Agenda</th>

					<th class="text-center">Minutes of the meeting</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>
			<tbody>
            <?php
 					include 'db_connect.php';
 					$users = $conn->query("SELECT * FROM minutes");
 					$i = 1;
 					while($row= $users->fetch_assoc()):
				 ?>
				 <tr>
				 	<td>
				 		<?php echo $i++ ?>
				 	</td>
				 	<td>
				 		<?php echo $row['type'] ?>
				 	</td>
				 	<td>
				 		<?php echo $row['date'] ?>
				 	</td>
                     <td>
    <?php
    // Assuming $row['time'] contains the time in a format like 'HH:MM:SS'
    $time = $row['time'];

    // Create a DateTime object from the time string
    $dateTime = new DateTime($time);

    // Format the time to 12-hour format with AM/PM
    echo $dateTime->format('h:i A');
    ?>
</td>

                     <td>
				 		<?php echo $row['location'] ?>
				 	</td>
                     <td>
				 		<?php echo $row['attendees'] ?>
				 	</td>
					 <td>
				 		<?php echo $row['agenda'] ?>
				 	</td>
					 <td>
    <?php if (!empty($row['file'])): ?>
        <a href="<?php echo $row['file']; ?>" target="_blank">View/Download Document</a>
    <?php else: ?>
        No document found
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
								    <a class="dropdown-item edit_minute" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Edit</a>
								    <div class="dropdown-divider"></div>
								    <a class="dropdown-item delete_minutes" href="javascript:void(0)" data-id = '<?php echo $row['id'] ?>'>Delete</a>
								  </div>
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
	
$('#new_minute').click(function(){
	uni_modal('New Meeting','manage_minutes.php')
})
$('.edit_minute').click(function(){
	uni_modal('Edit Meeting','manage_minutes.php?id='+$(this).attr('data-id'))
})
$('.delete_minutes').click(function(){
		_conf("Are you sure to delete this Meeting?","delete_minutes",[$(this).attr('data-id')])
	})
	function delete_minutes($id){
		start_load()
		$.ajax({
			url:'ajax.php?action=delete_minutes',
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