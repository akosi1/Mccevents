<?php
$host = 'localhost';
$dbname = 'u802714156_events';
$username = 'u802714156_eventsOrgPass';
$password = '1OrgEvents2025';

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get all tables
$tables = [];
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}

// Disable foreign key checks to avoid constraint errors
$conn->query("SET foreign_key_checks = 0");

foreach ($tables as $table) {
    $conn->query("DROP TABLE IF EXISTS `$table`");
    echo "Dropped table: $table<br>";
}

$conn->query("SET foreign_key_checks = 1");
$conn->close();

echo "<hr>All tables dropped successfully.";
?>
