<?php
if (isset($_GET['file'])) {
    // Get the file path from the URL
    $filePath = $_GET['file'];

    // Set headers to force download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
    header('Content-Length: ' . filesize($filePath));

    // Output the file
    readfile($filePath);
    exit;
} else {
    // No file specified
    echo "File not found.";
}
?>
