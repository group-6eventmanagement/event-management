<?php
require 'event_registration_system.php';
if (isset($_GET["event_id"])) {
    $event_id = intval($_GET["event_id"]);
    echo "<h2>Participants for Event ID: $event_id</h2>";
    $stmt = $conn->prepare("SELECT fullname, email, phone FROM participants WHERE event_id = ?");
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        echo "<table border='1'>
                <tr><th>Name</th><th>Email</th><th>Phone</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>".htmlspecialchars($row['fullname'])."</td>
                    <td>".htmlspecialchars($row['email'])."</td>
                    <td>".htmlspecialchars($row['phone'])."</td>
                  </tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No participants found for this event.</p>";
    }
    echo "<br><a href='events.php'>Back to Events</a>";
    $stmt->close();
} else {
    echo "<p>No event selected.</p>";
}
?>
