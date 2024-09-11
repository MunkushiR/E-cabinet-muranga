<?php
// Debug: Display errors and all warnings for development.
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db_connect.php');

// Initialize $documentsQuery and $documentsResult to avoid undefined variable warnings
$documentsQuery = null;
$documentsResult = null;

// Get the current user's position from the employees table
$currentUserId = $_SESSION['personal_number'];
$positionQuery = $conn->prepare("
    SELECT position 
    FROM employees 
    WHERE personal_number = ?
");

if (!$positionQuery) {
    die("Error in position query: " . $conn->error);
}

$positionQuery->bind_param("s", $currentUserId);
$positionQuery->execute();
$positionResult = $positionQuery->get_result();
$positionRow = $positionResult->fetch_assoc();
$currentPosition = $positionRow['position'];

$positionResult->free();
$positionQuery->close();

// Check if the user can upload documents: their name in the members table must match their position and department_id must be 1
$uploadPermissionQuery = $conn->prepare("
    SELECT COUNT(*) 
    FROM members 
    WHERE name = ? AND department_id = 1
");

if (!$uploadPermissionQuery) {
    die("Error in upload permission query: " . $conn->error);
}

$uploadPermissionQuery->bind_param("s", $currentPosition);
$uploadPermissionQuery->execute();
$uploadPermissionQuery->bind_result($canUploadAndView);
$uploadPermissionQuery->fetch();
$uploadPermissionQuery->close();

// Handle form submission for document upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload']) && isset($_POST['viewer_positions'])) {
    $viewerPositions = $_POST['viewer_positions']; // Array of selected viewer positions

    if ($canUploadAndView > 0 && !empty($viewerPositions) && isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
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
            $uploadQuery = $conn->prepare("
                INSERT INTO documents (name, path, type, uploaded_at, viewer_position) 
                VALUES (?, ?, ?, NOW(), ?)
            ");
            
            if (!$uploadQuery) {
                die("Error in upload query: " . $conn->error);
            }

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
if ($canUploadAndView > 0) {
    // If the user can upload, they can view all documents
    $documentsQuery = $conn->query("SELECT * FROM documents");
    if (!$documentsQuery) {
        die("Error fetching documents: " . $conn->error);
    }
    $documentsResult = $documentsQuery;
} else {
    // If the user can't upload, show documents where viewer_position matches the current position
    $documentsQuery = $conn->prepare("
        SELECT * 
        FROM documents 
        WHERE JSON_CONTAINS(viewer_position, ?)
    ");
    
    if (!$documentsQuery) {
        die("Error in document query: " . $conn->error);
    }

    $currentPositionJson = json_encode([$currentPosition]); // Convert to JSON array
    $documentsQuery->bind_param("s", $currentPositionJson);
    $documentsQuery->execute();
    $documentsResult = $documentsQuery->get_result();
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

    <!-- Restrict the upload form to users who have permission -->
    <?php if ($canUploadAndView > 0): ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="viewer_positions">Select Members to View Document</label>
                <select name="viewer_positions[]" id="viewer_positions" class="form-control" multiple required>
                    <?php
                    $membersQuery = $conn->query("
                        SELECT name 
                        FROM members 
                        WHERE department_id != 1
                    ");

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
                echo "<a href='view.php?id=".$row['id']."' class='btn btn-info'>View</a> ";
                echo "<a href='download_doc.php?id=".$row['id']."' class='btn btn-success'>Download</a> ";
                echo "<a href='edit_doc.php?id=".$row['id']."' class='btn btn-warning'>Edit</a>";
                echo "</td>";
                echo "</tr>";

                // Increment displayId for the next row
                $displayId++;
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
