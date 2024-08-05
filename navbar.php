
<style>
</style>
<nav id="sidebar" class='mx-lt-5 bg-success' >
		
		<div class="sidebar-list">

				<a href="index.php?page=home" class="nav-item nav-home"><span class='icon-field'><i class="fa fa-home"></i></span> Home</a>
				<a href="index.php?page=employee" class="nav-item nav-employee"><span class='icon-field'><i class="fa fa-user"></i></span> Employee list</a>
				<a href="index.php?page=department" class="nav-item nav-department"><span class='icon-field'><i class="fa fa-columns"></i></span> Meeting types</a>		
				<a href="index.php?page=meetings" class="nav-item nav-meetings"><span class='icon-field'><i class="fa fa-clipboard"></i></span> Minutes</a>
				<a href="index.php?page=cal-page" class="nav-item nav-cal-page"><span class='icon-field'><i class="fa fa-calendar"></i></span> Events</a>
				<a href="index.php?page=minutes" class="nav-item nav-minutes"><span class='icon-field'><i class="fa fa-clock"></i></span> Meetings</a>
				<a href="index.php?page=sendnotifications" class="nav-item nav-sendnotifications"><span class='icon-field'><i class="fa fa-comment"></i></span> Send Notifications</a>	
				<a href="index.php?page=documents" class="nav-item nav-documents"><span class='icon-field'><i class="fa fa-book"></i></span>Other Documents</a>	
				<?php if($_SESSION['login_type'] == 1): ?>
				<a href="index.php?page=attendance" class="nav-item nav-attendance"><span class='icon-field'><i class="fa fa-user"></i></span> Attendance</a>
				<a href="index.php?page=users" class="nav-item nav-users"><span class='icon-field'><i class="fa fa-users"></i></span> Users</a>
				
			<?php endif; ?>
		</div>

</nav>
<script>
	$('.nav-<?php echo isset($_GET['page']) ? $_GET['page'] : '' ?>').addClass('active')
</script>
