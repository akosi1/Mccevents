<?php
$host = 'localhost';
$dbname = 'u802714156_events';
$username = 'u802714156_eventsOrgPass';
$password = '1OrgEvents2025';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Database connection failed: " . $conn->connect_error);
}

echo "<h2>📋 Tables in '$dbname'</h2>";

$result = $conn->query("SHOW TABLES");

if ($result && $result->num_rows > 0) {
    echo "<ul>";
    while ($row = $result->fetch_array()) {
        echo "<li>" . htmlspecialchars($row[0]) . "</li>";
    }
    echo "</ul>";
} else {
    echo " No tables found in the database.";
}

$conn->close();
?>
