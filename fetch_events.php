<?php
require 'config.php';

header('Content-Type: application/json');

// Fetch events from the database
$events = $pdo->query("SELECT * FROM events")->fetchAll(PDO::FETCH_ASSOC);

$calendarEvents = [];
foreach ($events as $event) {
    $calendarEvents[] = [
        'title' => $event['title'],
        'start' => $event['start'],
        'end' => $event['end'],
        'allDay' => (bool) $event['all_day'],
        'extendedProps' => [
            'location' => $event['location'],
            'recurring' => (bool) $event['recurring']
        ]
    ];
}

echo json_encode($calendarEvents);
?>
