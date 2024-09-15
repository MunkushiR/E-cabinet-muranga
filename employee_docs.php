<?php
// Debug: Display errors and all warnings for development.
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db_connect.php');

// Start the session and ensure the user is logged in

if (!isset($_SESSION['personal_number'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}

// Get the current user's position from the employees table
$currentUserId = $_SESSION['personal_number'];
$positionQuery = $conn->prepare("SELECT position FROM employees WHERE personal_number = ?");

if (!$positionQuery) {
    die("Error in position query: " . $conn->error);
}

$positionQuery->bind_param("s", $currentUserId);
$positionQuery->execute();
$positionResult = $positionQuery->get_result();
$positionRow = $positionResult->fetch_assoc();
$currentPosition = $positionRow['position'];

// Close the position query result
$positionResult->free();
$positionQuery->close();

// Check if the user can upload and delete documents
$uploadDeletePermissionQuery = $conn->prepare("SELECT COUNT(*) FROM members WHERE name = ? AND department_id = 1");

if (!$uploadDeletePermissionQuery) {
    die("Error in upload/delete permission query: " . $conn->error);
}

$uploadDeletePermissionQuery->bind_param("s", $currentPosition);
$uploadDeletePermissionQuery->execute();
$uploadDeletePermissionQuery->bind_result($canUploadAndDelete);
$uploadDeletePermissionQuery->fetch();
$uploadDeletePermissionQuery->close();

// Handle document deletion
if ($canUploadAndDelete > 0 && isset($_GET['delete_id'])) {
    $deleteId = intval($_GET['delete_id']);
    
    // Retrieve the document path before deletion
    $deletePathQuery = $conn->prepare("SELECT path FROM documents WHERE id = ? AND JSON_CONTAINS(viewer_position, ?)");
    $currentPositionJson = json_encode($currentPosition); // Convert position to JSON format
    $deletePathQuery->bind_param("is", $deleteId, $currentPositionJson);
    $deletePathQuery->execute();
    $deletePathResult = $deletePathQuery->get_result();
    $deleteRow = $deletePathResult->fetch_assoc();
    
    if ($deleteRow) {
        $fileToDelete = $deleteRow['path'];
        
        // Delete the document record from the database
        $deleteQuery = $conn->prepare("DELETE FROM documents WHERE id = ?");
        $deleteQuery->bind_param("i", $deleteId);
        if ($deleteQuery->execute()) {
            // Delete the file from the server
            if (file_exists($fileToDelete)) {
                unlink($fileToDelete); // Delete the file
            }
            $message = "Document deleted successfully.";
        } else {
            $message = "Error deleting document: " . $conn->error;
        }
        $deleteQuery->close();
    } else {
        $message = "Document not found or you do not have permission to delete it.";
    }
    $deletePathQuery->close();

    // Redirect with a message
    header("Location: employeehome.php?page=employee_docs&message=" . urlencode($message));
    exit();
}

// Handle form submission for document upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload']) && isset($_POST['viewer_position'])) {
    $viewerPositions = $_POST['viewer_position']; // Array of selected viewer positions

    if ($canUploadAndDelete > 0 && !empty($viewerPositions) && isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $documentName = $_FILES['document']['name'];
        $uploadDir = 'uploads/';
        
        // Create the uploads directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        
        $uploadFile = $uploadDir . basename($documentName);
        
        if (move_uploaded_file($_FILES['document']['tmp_name'], $uploadFile)) {
            // Insert document information into the database
            $viewerPositionsJson = json_encode($viewerPositions); // Encode array to JSON for storage
            $uploadQuery = $conn->prepare("INSERT INTO documents (name, path, type, uploaded_at, viewer_position) VALUES (?, ?, ?, NOW(), ?)");

            $documentType = $_FILES['document']['type'];
            $uploadQuery->bind_param("ssss", $documentName, $uploadFile, $documentType, $viewerPositionsJson);
            
            if ($uploadQuery->execute()) {
                echo "<p>Document uploaded successfully.</p>";
            } else {
                echo "<p>Error uploading document: " . $conn->error . "</p>";
            }
            
            $uploadQuery->close();
        } else {
            echo "<p>Failed to upload document.</p>";
        }
    } else {
        echo "<p>You do not have permission to upload documents or required fields are missing.</p>";
    }
}

// Prepare document query based on user permissions
$documentsResult = null;
if ($canUploadAndDelete > 0) {
    // If the user can upload and delete, they can view all documents
    $documentsQuery = $conn->query("SELECT * FROM documents");
    if ($documentsQuery) {
        $documentsResult = $documentsQuery;
    }
} else {
    // If the user can't upload/delete, show documents where viewer_position matches the current position
    $documentsQuery = $conn->prepare("SELECT * FROM documents WHERE JSON_CONTAINS(viewer_position, ?)");
    if ($documentsQuery) {
        $currentPositionJson = json_encode($currentPosition); // Convert the current position to JSON format
        $documentsQuery->bind_param("s", $currentPositionJson);
        $documentsQuery->execute();
        $documentsResult = $documentsQuery->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document Management</title>
    <link rel="shortcut icon" type="image/ico" href="assets/img/logo.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Document Management</h1>

    <!-- Show any message if available -->
    <?php if (isset($_GET['message'])): ?>
        <div class="alert alert-info">
            <?php echo htmlspecialchars($_GET['message']); ?>
        </div>
    <?php endif; ?>

    <!-- Restrict the upload form to users who have permission -->
    <?php if ($canUploadAndDelete > 0): ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="viewer_position">Select Members to View Document</label>
                <select name="viewer_position[]" id="viewer_position" class="form-control" multiple required>
                    <?php
                    $membersQuery = $conn->query("SELECT name FROM members WHERE department_id != 1");

                    if ($membersQuery) {
                        while ($member = $membersQuery->fetch_assoc()) {
                            echo "<option value='".$member['name']."'>".$member['name']."</option>";
                        }
                        $membersQuery->free();
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="document">Upload Document</label>
                <input type="file" name="document" id="document" class="form-control" required>
            </div>
            <button type="submit" name="upload" class="btn btn-primary">Upload</button>
        </form>
        <hr>
    <?php else: ?>
        <p>You do not have permission to upload documents.</p>
    <?php endif; ?>

    <h2>Documents</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-center">#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Uploaded At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Initialize counter for display IDs
        $displayId = 1;
        if (is_null($documentsResult)) {
            echo "<tr><td colspan='5'>No documents found.</td></tr>";
        } elseif ($documentsResult->num_rows > 0) {
            while ($row = $documentsResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>".$displayId."</td>"; // Use displayId instead of database ID
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['type']."</td>";
                echo "<td>".$row['uploaded_at']."</td>";
                echo "<td>";
                
                // Modify the View link to open in a new tab for inline viewing
                echo "<a href='view.php?id=".$row['id']."' target='_blank' class='btn btn-primary'>View</a> ";
                
                // Display the Delete link only if the user has upload/delete permissions
                if ($canUploadAndDelete > 0) {
                    echo "<a href='delete.php?id=".$row['id']."' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this document?\");'>Delete</a>"; // New Delete Button
                }
                echo "</td>";
                echo "</tr>";

                $displayId++; // Increment the display ID for each row
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
