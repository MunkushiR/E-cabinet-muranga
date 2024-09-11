<?php
include 'db_connect.php';

$dept_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$dept_data = [];
$members_data = [];

// Fetch department data if ID is provided
if ($dept_id) {
    $result = $conn->query("SELECT * FROM department WHERE id = $dept_id");
    $dept_data = $result->fetch_assoc();

    // Fetch members associated with the department
    $members_result = $conn->query("SELECT * FROM members WHERE department_id = $dept_id");
    while ($member = $members_result->fetch_assoc()) {
        $members_data[] = $member;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = isset($_POST['action']) ? $_POST['action'] : '';

    // Add or update department
    if ($action == 'new_department') {
        $name = $_POST['dept_name'];
        $stmt = $conn->prepare("INSERT INTO department (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'type' => 'department']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add department']);
        }
        $stmt->close();
    } elseif ($action == 'update_department') {
        $name = $_POST['dept_name'];
        $dept_id = $_POST['dept_id'];
        $stmt = $conn->prepare("UPDATE department SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $dept_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'type' => 'department']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update department']);
        }
        $stmt->close();
    }

    // Add or update member
    if ($action == 'new_member') {
        $name = $_POST['member_name'];
        $dept_id = $_POST['member_dept_id'];
        $stmt = $conn->prepare("INSERT INTO members (name, department_id) VALUES (?, ?)");
        $stmt->bind_param("si", $name, $dept_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'type' => 'member']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to add member']);
        }
        $stmt->close();
    } elseif ($action == 'update_member') {
        $name = $_POST['member_name'];
        $member_id = $_POST['member_id'];
        $stmt = $conn->prepare("UPDATE members SET name = ? WHERE id = ?");
        $stmt->bind_param("si", $name, $member_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success', 'type' => 'member']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update member']);
        }
        $stmt->close();
    }

    // Delete member if delete_member_id is provided
    if (isset($_POST['delete_member_id'])) {
        $member_id = intval($_POST['delete_member_id']);
        $stmt = $conn->prepare("DELETE FROM members WHERE id = ?");
        $stmt->bind_param("i", $member_id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete member']);
        }
        $stmt->close();
        exit;
    }

    exit;
}

// Fetch individual member data if member_id is provided in GET request
if (isset($_GET['member_id'])) {
    $member_id = intval($_GET['member_id']);
    $result = $conn->query("SELECT * FROM members WHERE id = $member_id");

    if ($result) {
        $member_data = $result->fetch_assoc();
        if ($member_data) {
            echo json_encode($member_data);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Member not found']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to fetch member data from the database']);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dept_id ? 'Edit Department' : 'New Department'; ?></title>
    <link rel="stylesheet" href="path/to/bootstrap.min.css">
    <link rel="stylesheet" href="path/to/font-awesome.min.css">
    <script src="path/to/jquery.min.js"></script>
    <script src="path/to/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2><?php echo $dept_id ? 'Edit Department' : 'New Department'; ?></h2>
    
    <!-- Department Form -->
    <form id="manage_department_form">
        <div class="form-group">
            <label for="dept_name">Department Name:</label>
            <input type="text" class="form-control" id="dept_name" name="dept_name" value="<?php echo isset($dept_data['name']) ? $dept_data['name'] : ''; ?>" required>
        </div>
        <input type="hidden" name="dept_id" value="<?php echo $dept_id ? $dept_id : ''; ?>">
        <button type="submit" class="btn btn-primary"><?php echo $dept_id ? 'Update Department' : 'Add Department'; ?></button>
    </form>

    <?php if ($dept_id): ?>
    <h3 class="mt-5">Manage Members</h3>
    <!-- Members Table -->
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Member Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($members_data as $index => $member): ?>
            <tr>
                <td><?php echo $index + 1; ?></td>
                <td><?php echo $member['name']; ?></td>
                <td>
                    <button class="btn btn-primary edit_member" data-id="<?php echo $member['id']; ?>">Edit</button>
                    <button class="btn btn-danger delete_member" data-id="<?php echo $member['id']; ?>">Delete</button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Add/Edit Member Form -->
    <h3 class="mt-5">Add/Edit Member</h3>
<form id="member_form">
    <div class="form-group">
        <label for="member_name">Member Name:</label>
        <input type="text" class="form-control" id="member_name" name="member_name" required>
    </div>
    <input type="hidden" name="member_dept_id" value="<?php echo $dept_id; ?>">
    <input type="hidden" id="member_id" name="member_id" value="">
    <button type="submit" class="btn btn-primary">Add Member</button>
</form>

    <?php endif; ?>
</div>

<script>
  $(document).ready(function() {
    $('#manage_department_form').on('submit', function(e) {
        e.preventDefault();
        let action = $('input[name="dept_id"]').val() ? 'update_department' : 'new_department';
        $.ajax({
            type: 'POST',
            url: 'manage_department.php',
            data: $(this).serialize() + '&action=' + action,
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    alert('Department saved successfully!');
                    window.location.reload();
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function() {
                alert('An error occurred while saving data');
            }
        });
    });

    $('#member_form').submit(function(e) {
        e.preventDefault();
        let action = $('#member_id').val() ? 'update_member' : 'new_member';
        $.ajax({
            url: 'manage_department.php',
            method: 'POST',
            data: $(this).serialize() + '&action=' + action,
            success: function(response) {
                const res = JSON.parse(response);
                if (res.status === 'success') {
                    alert('Member added/updated successfully.');
                    window.location.reload();
                } else {
                    alert('Failed to add/update member.');
                }
            }
        });
    });

    // Editing a member
    $(document).on('click', '.edit_member', function() {
        const memberId = $(this).data('id');
        $.ajax({
            url: 'manage_department.php',
            method: 'GET',
            data: { member_id: memberId },
            dataType: 'json',
            success: function(member) {
                if (member && member.name) {
                    $('#member_name').val(member.name);
                    $('#member_id').val(member.id); // This hidden field is used for updating
                    $('#member_form button').text('Update Member');
                } else {
                    alert('Member not found');
                }
            },
            error: function() {
                alert('Failed to fetch member data.');
            }
        });
    });

    // Deleting a member
    $(document).on('click', '.delete_member', function() {
        const memberId = $(this).data('id');
        if (confirm('Are you sure you want to delete this member?')) {
            $.ajax({
                url: 'manage_department.php',
                method: 'POST',
                data: { delete_member_id: memberId },
                success: function(response) {
                    const res = JSON.parse(response);
                    if (res.status === 'success') {
                        alert('Member deleted successfully.');
                        window.location.reload();
                    } else {
                        alert('Failed to delete member.');
                    }
                }
            });
        }
    });
});

</script>

</body>
</html>
