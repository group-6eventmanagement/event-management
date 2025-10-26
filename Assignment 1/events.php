<?php
require 'event_registration_system.php'; // connect to the database

echo "<h2>All Events</h2>";

// select all events from the database
$sql = "SELECT id, name AS title, location, date AS event_date FROM events";
$result = $conn->query($sql);

// check if any events exist
if ($result && $result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Location</th>
                <th>Action</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".htmlspecialchars($row['title'])."</td>
                <td>".htmlspecialchars($row['event_date'])."</td>
                <td>".htmlspecialchars($row['location'])."</td>
                <td><a href='participants.php?event_id={$row['id']}'>View Participants</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No events found.</p>";
}
?>