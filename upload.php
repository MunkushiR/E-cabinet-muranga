<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {
    $file = $_FILES['document'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('pdf', 'doc', 'docx', 'jpg', 'png', 'xls', 'xlsx');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) { // 10MB limit
                $fileNewName = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'assets/'.$fileNewName;
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    $sql = "INSERT INTO documents (name, path, type) VALUES ('$fileName', '$fileNewName', '$fileType')";
                    if ($conn->query($sql)) {
                        echo "File uploaded successfully!";
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Error uploading file.";
                }
            } else {
                echo "File size exceeds limit.";
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file type.";
    }
} else {
    echo "No file uploaded.";
}
?>
