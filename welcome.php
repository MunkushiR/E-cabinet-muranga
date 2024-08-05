<?php include 'db_connect.php' ?>
<?php
$currentUser = $_SESSION['personal_number'];

?>
<div class="containe-fluid">
 <div class="row">
 <div class="col-lg-12">
			
            </div>
        </div>
    
        <div class="row mt-3 ml-3 mr-3">
                <div class="col-lg-12">
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
                                        <?php echo $conn->query("SELECT * FROM `employees`")->num_rows ?>
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
                                        <?php echo $conn->query("SELECT * FROM `employees`")->num_rows ?>
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


<style>
.card{
    padding-left:-120px;
    margin-left:-40px;
    margin-top: 50px;
    alignment: center;
}
.workers{
  padding-left:500px;
}
</style>


</table>
					   </div>
				   </div>