<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['document'])) {
    $file = $_FILES['document'];
    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];
    $fileType = $file['type'];

    // Split and get the file extension
    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    // Allowed file types
    $allowed = array('pdf', 'doc', 'docx', 'jpg', 'png', 'xls', 'xlsx');

    if (in_array($fileActualExt, $allowed)) {
        if ($fileError === 0) {
            if ($fileSize < 10000000) { // 10MB limit
                // Create unique file name to avoid collisions
                $fileNewName = uniqid('', true) . "." . $fileActualExt;
                $fileDestination = 'assets/' . $fileNewName;

                // Move the uploaded file
                if (move_uploaded_file($fileTmpName, $fileDestination)) {
                    
                    // Escape values to prevent SQL injection
                    $fileNameEscaped = mysqli_real_escape_string($conn, $fileName);
                    $fileNewNameEscaped = mysqli_real_escape_string($conn, $fileNewName);
                    $fileTypeEscaped = mysqli_real_escape_string($conn, $fileType);

                    // Insert into the database
                    $sql = "INSERT INTO documents (name, path, type) 
                            VALUES ('$fileNameEscaped', '$fileNewNameEscaped', '$fileTypeEscaped')";

                    // Execute the query
                    if ($conn->query($sql)) {
                        echo "File uploaded successfully!";
                    } else {
                        echo "Error: " . $conn->error;
                    }
                } else {
                    echo "Error moving file.";
                }
            } else {
                echo "File size exceeds the 10MB limit.";
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
