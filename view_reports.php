<html><head><style>table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #ddd;
}
</style></head><body><?php
// Include the database connection script
include_once "includes/connection.php";

// Query to retrieve reports from the database
$query = "SELECT report_id, note_id, user_id, reason, comments, report_date FROM reports";
$result = mysqli_query($conn, $query);

// Check if there are any reports
if (mysqli_num_rows($result) > 0) {
    // Output data of each report
    echo "<h2>Reports</h2>";
    echo "<table>";
    echo "<tr><th>Report ID</th><th>Note ID</th><th>User ID</th><th>Reason</th><th>Comments</th><th>Reported At</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        // Display report details
        echo "<tr>";
        echo "<td>" . $row['report_id'] . "</td>";
        echo "<td>" . $row['note_id'] . "</td>";
        echo "<td>" . $row['user_id'] . "</td>";
        echo "<td>" . $row['reason'] . "</td>";
		echo "<td>" . $row['comments'] . "</td>";
        echo "<td>" . $row['report_date'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    // No reports found
    echo "No reports found.";
}

// Close the database connection
mysqli_close($conn);
?>
</body></html>
