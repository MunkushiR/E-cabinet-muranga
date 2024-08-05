<?php
include 'db_connect.php';

if (isset($_GET['action']) && $_GET['action'] == 'save_meeting') {
    $type = $_POST['department_id'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $content = $_POST['content'];
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $file = '';

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['file']['tmp_name'];
        $fileName = $_FILES['file']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $uploadFileDir = './uploaded_files/';
        if (!file_exists($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $file = $dest_path;
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error moving the uploaded file']);
            exit;
        }
    }

    $data = [
        ':type' => $type,
        ':date' => $date,
        ':time' => $time,
        ':content' => $content,
        ':file' => $file
    ];

    if ($id == 0) {
        $sql = "INSERT INTO meetings (type, date, time, content, file) VALUES (:type, :date, :time, :content, :file)";
    } else {
        $sql = "UPDATE meetings SET type = :type, date = :date, time = :time, content = :content, file = :file WHERE id = :id";
        $data[':id'] = $id;
    }

    $stmt = $conn->prepare($sql);
    $save = $stmt->execute($data);

    if ($save) {
        echo 1;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error saving the meeting data']);
    }
}
?>
