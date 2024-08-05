<?php
include('db_connect.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document Management system</title>
    <link rel="shortcut icon" type="image/ico" href="assets/img/logo.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<link rel="shortcut icon" type="image/ico" href="assets/img/logo.png" />
</head>
<body>
<div class="container">
    <h3>Documents</h3>
    <hr>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Type</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM documents";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['type']."</td>";
                    echo "<td>".$row['uploaded_at']."</td>";
                    echo "<td>";
                    echo "<a href='view.php?id=".$row['id']."' class='btn btn-info'>View</a> ";
                    echo "<a href='dowload_doc.php?id=".$row['id']."' class='btn btn-success'>Download</a> ";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No documents found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
