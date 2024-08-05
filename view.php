?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="shortcut icon" type="image/ico" href="assets/img/logo.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<link rel="shortcut icon" type="image/ico" href="assets/img/logo.png" />
</head>
<?php
include('db_connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM documents WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = 'assets/'.$row['path'];

        if (file_exists($filePath)) {
            $fileType = mime_content_type($filePath);
            header('Content-Type: '.$fileType);
            readfile($filePath);
        } else {
            echo "File does not exist.";
        }
    } else {
        echo "No record found with id: $id";
    }
} else {
    echo "Invalid request.";
}
?>
