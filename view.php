<?php
// Connect to the database
$host = 'localhost'; // your database host
$user = 'root';      // your database username
$password = '';      // your database password
$dbname = 'county'; // your database name

$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the input to prevent SQL injection

    // First, update viewer_position to remove restriction (e.g., setting it to null or an empty value)
    $updateSql = "UPDATE documents SET viewer_position = '' WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("i", $id);
    if (!$updateStmt->execute()) {
        die("Failed to remove restriction: " . $updateStmt->error);
    }
    $updateStmt->close();

    // Retrieve the document details after updating the viewer_position
    $sql = "SELECT * FROM documents WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Ensure the path does not have duplicate 'uploads/'
        $filePath = $row['path'];
        if (strpos($filePath, 'uploads/') === false) {
            $filePath = 'uploads/' . $filePath; // Add 'uploads/' if it's not already in the path
        }

        // Debugging: Check if the file exists on the server
        if (!file_exists($filePath)) {
            echo "File path does not exist on the server: " . htmlspecialchars($filePath);
            exit;
        }

        echo "<h1>" . htmlspecialchars($row['name']) . "</h1>";
        echo "<p>Uploaded at: " . htmlspecialchars($row['uploaded_at']) . "</p>";
        echo "<iframe src='" . htmlspecialchars($filePath) . "' width='100%' height='600px'></iframe>"; // Use htmlspecialchars for security
    } else {
        echo "Document not found in the database with ID: " . htmlspecialchars($id);
    }

    $stmt->close();
} else {
    echo "No document ID specified.";
}

$conn->close();
?>
