<?php
require 'event_registration_system.php';
$stmt = $conn->prepare("SELECT id, name, location, date FROM events");
$stmt->execute();
$result = $stmt->get_result();
echo "<h2>All Events</h2>";
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
                <td>".htmlspecialchars($row['name'])."</td>
                <td>".htmlspecialchars($row['date'])."</td>
                <td>".htmlspecialchars($row['location'])."</td>
                <td><a href='participants.php?event_id={$row['id']}'>View Participants</a></td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No events found.</p>";
}
$stmt->close();
?>
