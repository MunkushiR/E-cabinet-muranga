<?php 
include('db_connect.php');
if(isset($_GET['id'])){
$user = $conn->query("SELECT * FROM meetings where id =".$_GET['id']);
foreach($user->fetch_array() as $k =>$v){
	$meta[$k] = $v;
}
}
?>

<div class="container-fluid">
	<form id='meeting_frm'>
	<div class="form-group">
			<label>Meeting Type</label>
			<select class="custom-select browser-default select2" name="type">
				<option value=""></option>
			<?php
			$dept = $conn->query("SELECT * from department order by name asc");
			while($row=$dept->fetch_assoc()):
			?>
				<option value="<?php echo $row['id'] ?>" value="<?php echo isset($type) ? $type : "" ?>"<?php echo isset($id) && $id == $row['id'] ? "selected" :"" ?>><?php echo $row['name'] ?></option>
			<?php endwhile; ?>
			</select>
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
		<div class="form-group">
			<label>File</label>
			<input type="text" name ="file" id="content" placeholder="required" class="form-control" value="<?php echo isset($file) ? $file : "" ?>" />
		</div>
		

	</form>
</div>
<script type="text/javascript">
        $(document).ready(function() {
            $('#table').DataTable();

            $('.edit_meeting').click(function() {
                var id = $(this).attr('data-id');
                uni_modal("Edit Meeting", "edit_meeting.php?id=" + id);
            });

            $('.remove_meeting').click(function() {
                var id = $(this).attr('data-id');
                _conf("Are you sure to delete this meeting?", "remove_meeting", [id]);
            });
        });

        function remove_meeting(id) {
            start_load();
            $.ajax({
                url: 'ajax.php?action=delete_meeting',
                method: "POST",
                data: { id: id },
                error: function(err) {
                    console.log(err);
                },
                success: function(resp) {
                    if (resp == 1) {
                        alert_toast("Meeting data successfully deleted", "success");
                        setTimeout(function() {
                            location.reload();
                        }, 1000);
                    }
                }
            });
        }
    </script>
