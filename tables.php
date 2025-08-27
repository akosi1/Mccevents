<?php
$host = 'localhost';
$dbname = 'u802714156_events';  // Your configured database
$username = 'u802714156_eventsOrgPass';
$password = '1OrgEvents2025';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(" Database connection failed: " . $conn->connect_error);
}

// Show current database name
$db_result = $conn->query("SELECT DATABASE() AS db");
$row = $db_result->fetch_assoc();
$currentDb = $row['db'];

echo "<h2> Current Database: <code>$currentDb</code></h2>";

// Show all tables
$result = $conn->query("SHOW TABLES");

if ($result && $result->num_rows > 0) {
    echo "<h3> Tables in '$currentDb':</h3><ul>";
    while ($row = $result->fetch_array()) {
        echo "<li>" . htmlspecialchars($row[0]) . "</li>";
    }
    echo "</ul>";
} else {
    echo " No tables found in the database.";
}

$conn->close();
?>
