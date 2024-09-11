<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include('db_connect.php');

// Check if the 'id' parameter is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare SQL query to fetch document details
    $sql = "SELECT * FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if document is found
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $filePath = $row['path']; // Assume the 'path' column contains the relative path

        // Debugging: Output file path
        echo "<p>File Path: " . htmlspecialchars($filePath) . "</p>";

        // Check if the file exists
        if (file_exists($filePath)) {
            $fileType = mime_content_type($filePath);
            header('Content-Type: ' . $fileType);
            header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        } else {
            echo "<p>File does not exist at path: " . htmlspecialchars($filePath) . "</p>";
        }
    } else {
        echo "<p>No document found with ID: " . htmlspecialchars($id) . "</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid request. Document ID not provided or is invalid.</p>";
}
?>
