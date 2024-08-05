<?php 
include('db_connect.php');
if(isset($_GET['work_id'])){
$user = $conn->query("SELECT * FROM `register`where work_id = '$work_id'");
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
   
}
}
?>
<div class="container-fluid">
	
	<form action="" id="manage-passwords">
		<input type="hidden" name="work_id" value="<?php echo isset($meta['work_id']) ? $meta['work_id']: '' ?>">
		<div class="form-group">
			<label for="name">Work_id</label>
			<input type="text" name="work_id" id="work_id" class="form-control" value="<?php echo isset($meta['work_id']) ? $meta['work_id']: '' ?>" required>
		</div>
		<div class="form-group">
			<label for="password">Password</label>
			<input type="password" name="password" id="password" class="form-control" value="<?php echo isset($meta['password']) ? $meta['password']: '' ?>" required>
		</div>
	</form>
</div>
<script>
	$('#manage-passwords').submit(function(e){
		e.preventDefault();
		start_load()
		$.ajax({
			url:'ajax.php?action=save_password',
			method:'POST',
			data:$(this).serialize(),
			success:function(resp){
				if(resp ==1){
					alert_toast("Data successfully saved",'success')
					setTimeout(function(){
						location.reload()
					},1500)
				}
			}
		})
	})
</script>