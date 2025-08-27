<?php

$host = '127.0.0.1:3307';
$dbname = 'u802714156_events';
$username = 'u802714156_eventsOrgPass';
$password = '1OrgEvents2025';

$sqlFilePath = __DIR__ . '/event.sql'; 
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = file_get_contents($sqlFilePath);
if ($sql === false) {
    die("Failed to read SQL file.");
}

$queries = array_filter(array_map('trim', explode(";", $sql)));
$success = 0;
$fail = 0;
foreach ($queries as $query) {
    if (!empty($query)) {
        if ($conn->query($query) === TRUE) {
            $success++;
        } else {
            echo "Error on query: $query<br>Error: " . $conn->error . "<br><br>";
            $fail++;
        }
    }
}
$conn->close();

echo " Import completed.<br>";
echo "Successful queries: $success<br>";
echo "Failed queries: $fail<br>";
?>
