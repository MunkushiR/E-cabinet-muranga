<?php
require('db_connect.php');

// Check if ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = intval($_GET['id']);

    // Fetch the document details to get the file path
    $stmt = $conn->prepare("SELECT * FROM documents WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $document = $result->fetch_assoc();

    if ($document) {
        $filePath = $document['path']; // Assuming you have a 'path' column in your documents table

        // Delete the file from the server
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete the record from the database
        $stmt = $conn->prepare("DELETE FROM documents WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            // Redirect with a success message
            header("Location: employeehome.php?page=employee_docs&message=" . urlencode("Document deleted successfully."));
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Document not found.";
    }
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
