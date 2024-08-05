<?php include 'db_connect.php' ?>
<style>
   
</style>

<div class="containe-fluid">

	<div class="row">
		<div class="col-lg-12">
			
		</div>
	</div>

	<div class="row mt-3 ml-3 mr-3">
			<div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <?php echo "Welcome back ". $_SESSION['login_name']."!"  ?>
                                        
                    </div>
                    
                </div>
            </div>
	</div>
</div>


<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                        Meeting types</div>
                        <h4><b>
                        <?php echo $conn->query("SELECT * FROM `department`")->num_rows ?>
                        </b></h4>
                </div>
                <div class="col-auto">
                    <i class="fas fa-comments fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"> <i class="fa fa-clipboard text-primary "></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM `users` ")->num_rows ?>
                                        </b></h4>
                                        <p><b>System Users</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"><i class="fa fa-user-friends text-primary"></i></span>
                                        <h4><b>
                                        <?php echo $conn->query("SELECT * FROM `register`")->num_rows ?>
                                        </b></h4>
                                        <p><b>Total Employees</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"><i class="fa fa-clipboard text-primary"></i></span>
                                        <h4><b>
                                        <?php echo $conn->query("SELECT * FROM `events`")->num_rows ?>
                                        </b></h4>
                                        <p><b>Total Events</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-md-3 mb-3">
                            <div class="card">
                                <div class="card-body bg-light">
                                    <div class="card-body text-dark">
                                        <span class="float-right summary_icon"> <i class="fa fa-sms text-primary "></i></span>
                                        <h4><b>
                                            <?php echo $conn->query("SELECT * FROM `notifications`")->num_rows ?>
                                        </b></h4>
                                        <p><b>Total Notifications</b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

</body>

</html>