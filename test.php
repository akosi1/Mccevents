<?php
$host = 'events-org.com';       // Your DB host
$port = 3307;                   // Your DB port (change if needed)
$dbname = 'u802714156_events'; // Your DB name
$username = 'u802714156_eventsOrgPass';  // Your DB username
$password = '1OrgEvents2025';   // Your DB password

// Create connection
$mysqli = new mysqli($host, $username, $password, $dbname, $port);

// Check connection
if ($mysqli->connect_error) {
    die('Connection failed: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
} 

echo "Connection successful!\n";

// Run a simple test query
if ($result = $mysqli->query("SELECT 1")) {
    echo "Test query executed successfully.";
    $result->close();
} else {
    echo "Test query failed: " . $mysqli->error;
}

$mysqli->close();
?>
