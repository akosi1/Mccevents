<?php
$mysqli = new mysqli('events-org.com', 'u802714156_eventsOrgPass', '1OrgEvents2025', 'u802714156_events', 3307);

if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
} else {
    echo "Connection successful!";
}
?>
