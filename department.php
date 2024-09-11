<?php 
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <button class="btn btn-primary float-right btn-sm" id="new_department"><i class="fa fa-plus"></i> New department</button>
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
                            <th class="text-center">Meeting Type</th>
                            <th class="text-center">Members</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        include 'db_connect.php';
                        
                        // Query to get departments
                        $department = $conn->query("SELECT * FROM department ORDER BY id ASC");
                        $i = 1;
                        while ($row = $department->fetch_assoc()):
                            $dept_id = $row['id'];
                            $members = $conn->query("SELECT * FROM members WHERE department_id = $dept_id");
                    ?>
                        <tr>
                            <td><?php echo $i++ ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td>
                                <ul>
                                <?php while ($member = $members->fetch_assoc()): ?>
                                    <li><?php echo $member['name']; ?></li>
                                <?php endwhile; ?>
                                </ul>
                            </td>
                            <td>
                                <center>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary">Action</button>
                                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item edit_minute" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Edit</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item delete_department" href="javascript:void(0)" data-id='<?php echo $row['id'] ?>'>Delete</a>
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
    $('#new_department').click(function(){
        uni_modal('New Department', 'manage_department.php');
    });

    $('.edit_minute').click(function(){
        uni_modal('Edit Department', 'manage_department.php?id=' + $(this).attr('data-id'));
    });

    $('.delete_department').click(function(){
        _conf("Are you sure to delete this Department?", "delete_department", [$(this).attr('data-id')]);
    });

    function delete_department(id) {
        start_load();
        $.ajax({
            url: 'ajax.php?action=delete_department',
            method: 'POST',
            data: { id: id },
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Data successfully deleted", 'success');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            }
        });
    }
</script>
