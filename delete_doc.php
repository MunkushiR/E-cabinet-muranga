<?php
require('db_connect.php');

// Check if ID is provided and valid
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
        if ($filePath && file_exists($filePath)) {
            if (!unlink($filePath)) {
                echo "Error deleting the file.";
                exit();
            }
        }

        // Delete the record from the database
        $stmt = $conn->prepare("DELETE FROM documents WHERE id = ?");
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            // Redirect back to the documents list page
            header("Location: index.php?page=documents");
            exit();
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Document not found.";
    }

    $stmt->close();
} else {
    echo "Invalid ID.";
}

$conn->close();
?>
