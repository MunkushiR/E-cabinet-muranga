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
	<form id='meeting_frm'>
		<div class="form-group">
			<label>Type</label>
			<input type="hidden" name="id" value="<?php echo isset($id) ? $id : "" ?>" />
			<input type="text" name="type" id="type" required="required" class="form-control" value="<?php echo isset($type) ? $type : "" ?>" />
		</div>
		<div class="form-group">
			<label>Date:</label>
			<input type="text" name="date" id="date" required="required" class="form-control" value="<?php echo isset($date) ? $date : "" ?>" />
		</div>
		<div class="form-group">
			<label>Time</label>
			<input type="text" name="time" id="time" required="required" class="form-control" value="<?php echo isset($time) ? $time : "" ?>" />
		</div>
		<div class="form-group">
			<label>Content</label>
			<input type="text" name ="content" id="content" placeholder="required" class="form-control" value="<?php echo isset($content) ? $content : "" ?>" />
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
		$('#meeting_frm').submit(function(e){
				e.preventDefault()
				start_load();
			$.ajax({
				url:'ajax.php?action=save_meeting',
				method:"POST",
				data:$(this).serialize(),
				error:err=>console.log(),
				success:function(resp){
						if(resp == 1){
							alert_toast("Meeting's data successfully saved","success");
								setTimeout(function(){
								location.reload();

							},1000)
						}
				}
			})
		})
	})
</script>