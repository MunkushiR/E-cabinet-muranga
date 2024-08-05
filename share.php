<?php
include('db_connect.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM documents WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = 'assets'.$row['path'];

    }
}