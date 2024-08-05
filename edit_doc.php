<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];

    $sql = "UPDATE documents SET name = '$name' WHERE id = $id";
    if ($conn->query($sql)) {
        echo "Document updated successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
} elseif (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM documents WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <title>Edit Document</title>
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css">
        </head>
        <body>
        <div class="container">
            <h1>Edit Document</h1>
            <form action="edit_doc.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <div class="form-group">
                    <label for="name">Document Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo $row['name']; ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
        </body>
        </html>
        <?php
    } else {
        echo "No record found with id: $id";
    }
} else {
    echo "Invalid request.";
}
?>
