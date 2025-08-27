<?php
// database credential
$host = "127.0.0.1:3306";
$dbname = "u802714156_events";
$username = "u802714156_eventsOrgPass";
$password = "1OrgEvents2025";

//create connections
	$conn = new mysqli($host, $username, $password, $dbname);

	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
		//echo "Connection Faileds";
	}
	echo "Connection Successs";

	
?>