<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = "127.0.0.1";  // No need to include port here if it's the default MySQL port
$dbname = "u802714156_events";
$username = "u802714156_eventsOrgPass";
$password = "1OrgEvents2025";

// Create connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Display connection error
    die("Connection failed: " . $conn->connect_error);
}

// If connected successfully
echo "Connection Successful!";
$conn->close();  // It's always a good idea to close the connection when done.
?>
