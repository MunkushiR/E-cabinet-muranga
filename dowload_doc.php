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
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename='.basename($filePath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            flush();
            readfile($filePath);
            exit;
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
