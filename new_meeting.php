<?php 
include 'db_connect.php'; 
if(isset($_GET['id'])){
	$qry = $conn->query("SELECT * FROM meetings where id = ".$_GET['id'])->fetch_array();
	foreach($qry as $k => $v){
		$$k = $v;
	}
}
?>

<div class="container-fluid">
	<form id='employee_frm'>
    <div class="form-group">
			<label>Meeting Type</label>
			<select class="custom-select browser-default select2" name="type" id="type">
				<option value=""></option>
			<?php
			$dept = $conn->query("SELECT * from department order by name asc");
			while($row=$dept->fetch_assoc()):
			?>
				<option value="<?php echo $row['id'] ?>" <?php echo isset($id) && $id == $row['id'] ? "selected" :"" ?>><?php echo $row['name'] ?></option>
			<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group">
			<label>Date</label>
			<input type="hidden" name="date" value="<?php echo isset($user_id) ? $user_id : "" ?>" />
			<input type="date" name="date" id="date" required="required" class="form-control" value="<?php echo isset($date) ? $date : "" ?>" />
		</div>
		<div class="form-group">
			<label>Time</label>
			<input type="time" name="time" id="time" required="required" class="form-control" value="<?php echo isset($time) ? $time : "" ?>" />
		</div>
		<div class="form-group">
			<label>Content</label>
			<input type="text" name="content" id="content" required="required" class="form-control" value="<?php echo isset($content) ? $content : "" ?>" />
		</div>
		<div class="form-group">
			<label>Upload file</label>
			<input type="file" name ="file" id="file"  class="form-control" value="<?php echo isset($file) ? $file : "" ?>" />
		</div>
		
	</form>
</div>
<script>
	$('[name="id"]').change(function(){
		var did = $(this).val()
		$('[name="id"] .opt').each(function(){
			if($(this).attr('data-did') == did){
				$(this).attr('disabled',false)
			}else{
				$(this).attr('disabled',true)
			}
		})
	})
	$(document).ready(function(){
		$('.select2').select2({
			placeholder:"Please Select Here",
			width:"100%"
		})
		$('#employee_frm').submit(function(e){
				e.preventDefault()
				start_load();
			$.({
				url:'ajax.php?action=save_meeting',
				method:"POST",
				data:$(this).serialize(),
				error:err=>console.log(),
				success:function(resp){
						if(resp == 1){
							alert_toast("Meeting data successfully saved","success");
								setTimeout(function(){
								location.reload();

							},1000)
						}
				}
			})
		})
	})
</script>