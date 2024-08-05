<?php
require 'db_connect.php';

// Fetch events where notification has not been sent and the start time is within the next 10 minutes
$events = $pdo->query("SELECT * FROM events WHERE notification_sent = 0 AND start <= NOW() + INTERVAL 10 MINUTE")->fetchAll(PDO::FETCH_ASSOC);

foreach ($events as $event) {
    // Send notification logic here (e.g., email, SMS, etc.)
    echo "Sending notification for event: " . $event['title'] . "\n";

    // Mark the notification as sent
    $stmt = $pdo->prepare("UPDATE events SET notification_sent = 1 WHERE id = ?");
    $stmt->execute([$event['id']]);
}
?>
