<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];
    $all_day = isset($_POST['all_day']) ? 1 : 0;
    $location = $_POST['location'];
    $recurring = isset($_POST['recurring']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO events (title, start, end, all_day, location, recurring) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $start, $end, $all_day, $location, $recurring]);

    header("Location: index.php?page=cal-page");
}
?>
