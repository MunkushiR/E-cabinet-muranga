<!DOCTYPE html>
<html>
<head>
    <title>Event Calendar</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tooltip.js@1.3.3/dist/umd/tooltip.min.js"></script>
</head>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

h1, h2 {
    color: #4CAF50;
}

form {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 20px auto;
}

form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
}

form input[type="text"],
form input[type="datetime-local"],
form input[type="checkbox"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

form input[type="submit"] {
    background: #4CAF50;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
}

form input[type="submit"]:hover {
    background: #45a049;
}

form .checkbox-container {
    display: flex;
    align-items: center;
}

form .checkbox-container input[type="checkbox"] {
    width: auto;
    margin-right: 10px;
}
</style>
<body>
    <div id="calendar"></div>
    <form action="add_event.php" method="post">
   <center> <h2>Add New Event</h2></center>
        <label>Title:</label>
        <input type="text" name="title" required><br>
        <label>Start Date & Time:</label>
        <input type="datetime-local" name="start" required><br>
        <label>End Date & Time:</label>
        <input type="datetime-local" name="end" required><br>
        <label>All Day:</label>
        <input type="checkbox" name="all_day"><br>
        <label>Location:</label>
        <input type="text" name="location"><br>
        <label>Recurring:</label>
        <input type="checkbox" name="recurring"><br>
        <center><input type="submit" value="Add Event"><center>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: 'fetch_events.php', // Fetch events from the backend
            eventDidMount: function(info) {
                if (info.event.extendedProps.location) {
                    var tooltip = new Tooltip(info.el, {
                        title: 'Location: ' + info.event.extendedProps.location,
                        placement: 'top',
                        trigger: 'hover',
                        container: 'body'
                    });
                }
            }
        });

        calendar.render();
    });
    </script>
</body>
</html>
