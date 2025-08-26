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
} else {
    echo "Connection successful!";
}

// Optionally run a simple query if connection is successful
if (!$mysqli->connect_error) {
    $result = $mysqli->query("SELECT 1");
    if ($result) {
        echo "\nQuery successful!";
        $result->close();
    } else {
        echo "\nQuery failed: " . $mysqli->error;
    }
}

$mysqli->close();
?>
