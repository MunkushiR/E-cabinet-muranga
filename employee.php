<?php include('db_connect.php') ?>
<div class="container-fluid">
    <div class="col-lg-12">
        <br />
        <br />
        <div class="card">
            <div class="card-header">
                <span><b>Employee List</b></span>
                <button class="btn btn-primary btn-sm btn-block col-md-3 float-right" type="button" id="new_emp_btn"><span class="fa fa-plus"></span> Add Employee</button>
            </div>
            <div class="card-body">
                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Firstname</th>
                            <th scope="col">Lastname</th>
                            <th scope="col">Personal details</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $d_arr[0] = "Unset";
                            $p_arr[0] = "Unset";
                            $dept = $conn->query("SELECT * from department order by name asc");
                            while($row=$dept->fetch_assoc()):
                                $d_arr[$row['id']] = $row['name'];
                            endwhile;
                            $pos = $conn->query("SELECT * from position order by name asc");
                            while($row=$pos->fetch_assoc()):
                                $p_arr[$row['id']] = $row['name'];
                             endwhile;
                            $employee_qry=$conn->query("SELECT * FROM `employees`") or die(mysqli_error());
                            $i = 1;
                            while($row=$employee_qry->fetch_array()){
                        ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $row['firstname'];?></td>
                            <td><?php echo $row['lastname'];?></td>
                            <td>
                                <b>Personal Number: </b><?php echo $row['personal_number'];?><br>
                                <b>Work Email: </b><?php echo $row['work_email'];?><br>
                                <b>Position: </b> <?php echo $row['position'];?><br>
                                <b>Phone Number: </b> <?php echo $row['phonenumber'];?>
                            </td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary">Action</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item edit_employee" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item remove_employee" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Delete</a>
                                        </div>
                                        <a href="generate_employee.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-success"><i class="fa fa-book"></i></a>
                                    </div>
                                </center>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('#table').DataTable();

        $('#new_emp_btn').click(function(){
            uni_modal("New Employee", "manage_employee.php");
        });

        $(document).on('click', '.edit_employee', function(){
            var id = $(this).data('id');
            uni_modal("Edit Employee", "manage_employee.php?id=" + id);
        });

        $(document).on('click', '.remove_employee', function(){
            var id = $(this).data('id');
            _conf("Are you sure to delete this employee?", "remove_employee", [id]);
        });
    });

    function remove_employee(id){
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_employee',
            method: "POST",
            data: {id: id},
            error: err => console.log(err),
            success: function(resp){
                if(resp == 1){
                    alert_toast("Employee's data successfully deleted", "success");
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            }
        });
    }
</script>
