<?php
// Debug: Display errors and all warnings for development.
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('db_connect.php');
// Initialize variables
$documentsQuery = null;
$documentsResult = null;

// Handle form submission for document upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['upload']) && isset($_POST['viewer_positions'])) {
    $viewerPositions = $_POST['viewer_positions']; // Array of selected viewer positions

    if (!empty($viewerPositions) && isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
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
        echo "<p>Required fields are missing or file upload error occurred.</p>";
    }
}

// Handle form submission for document edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit']) && isset($_POST['edit_document_id'])) {
    $documentId = $_POST['edit_document_id'];
    $newName = $_POST['edit_name'];
    $newViewerPositions = $_POST['edit_viewer_positions'];
    
    $newViewerPositionsJson = json_encode($newViewerPositions);
    
    $updateQuery = $conn->prepare("
        UPDATE documents 
        SET name = ?, viewer_position = ? 
        WHERE id = ?
    ");
    
    if (!$updateQuery) {
        die("Error in update query: " . $conn->error);
    }

    $updateQuery->bind_param("ssi", $newName, $newViewerPositionsJson, $documentId);
    
    if ($updateQuery->execute()) {
        echo "<p>Document updated successfully.</p>";
    } else {
        echo "<p>Error updating document: " . $conn->error . "</p>";
    }
    
    $updateQuery->close();
}

// Prepare document query to show all documents
$documentsQuery = $conn->query("SELECT * FROM documents ORDER BY uploaded_at DESC");
if (!$documentsQuery) {
    die("Error fetching documents: " . $conn->error);
}
$documentsResult = $documentsQuery;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Document Management</title>
    <link rel="shortcut icon" type="image/ico" href="assets/img/logo.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h1>Document Management</h1>

    <!-- Upload form accessible to all users -->
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
        $documentPath = $row['path']; // Get document path from database
        echo "<tr>";
        echo "<td>".$displayId."</td>"; // Use displayId instead of database ID
        echo "<td>".$row['name']."</td>";
        echo "<td>".$row['type']."</td>";
        echo "<td>".$row['uploaded_at']."</td>";
        echo "<td>";
        // View the document in a new tab
        echo '<a href="view.php?id=' . $row['id'] . '" target="_blank" class="btn btn-info">View</a>';

        // Download the document via download_doc.php script
        echo "<a href='download_doc.php?id=".$row['id']."' class='btn btn-success'>Download</a> ";
        echo "<button type='button' class='btn btn-warning' data-toggle='modal' data-target='#editModal' data-id='".$row['id']."' data-name='".$row['name']."' data-viewers='".htmlspecialchars($row['viewer_position'], ENT_QUOTES, 'UTF-8')."'>Edit</button>";
        echo "<a href='delete_doc.php?id=".$row['id']."' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this document?\");'>Delete</a>"; // New Delete Button
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm" method="POST">
                    <div class="form-group">
                        <label for="edit_name">Document Name</label>
                        <input type="text" class="form-control" id="edit_name" name="edit_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_viewer_positions">Select Members to View Document</label>
                        <select name="edit_viewer_positions[]" id="edit_viewer_positions" class="form-control" multiple required>
                            <?php
                            // Fetch members excluding department_id = 1
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

                    <input type="hidden" id="edit_document_id" name="edit_document_id">
                    <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    $('#editModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var documentId = button.data('id'); // Extract document ID
        var documentName = button.data('name'); // Extract document name
        var viewerPositions = button.data('viewers'); // JSON encoded viewer positions

        // Update the modal's content with document details.
        var modal = $(this);
        modal.find('#edit_name').val(documentName);  // Set document name
        modal.find('#edit_document_id').val(documentId); // Set document ID

        // Parse viewer positions and set the values in the select dropdown.
        var viewerPositionsArray = JSON.parse(viewerPositions); // Parse JSON data

        // Clear any previously selected values
        modal.find('#edit_viewer_positions').val([]).trigger('change'); // Clear previous selections

        // Set the current selections
        modal.find('#edit_viewer_positions').val(viewerPositionsArray).trigger('change'); // Highlight the selected positions
    });
});

</script>
</body>
</html>