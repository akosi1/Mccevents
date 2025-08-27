<?php
// Show errors (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database credentials
$host = 'localhost';
$dbname = 'u802714156_events';
$username = 'u802714156_eventsOrgPass';
$password = '1OrgEvents2025';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['sqlfile']) && $_FILES['sqlfile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/';
        $uploadFile = $uploadDir . 'aps.sql';

        $ext = pathinfo($_FILES['sqlfile']['name'], PATHINFO_EXTENSION);
        if (strtolower($ext) !== 'sql') {
            echo " Please upload a valid .sql file.";
            exit;
        }

        if (!move_uploaded_file($_FILES['sqlfile']['tmp_name'], $uploadFile)) {
            echo " Failed to upload file.";
            exit;
        }

        echo " File uploaded successfully.<br>";

        //  Import into database
        $conn = new mysqli($host, $username, $password, $dbname);
        if ($conn->connect_error) {
            die(" Database connection failed: " . $conn->connect_error);
        }

        $sql = file_get_contents($uploadFile);
        if ($sql === false) {
            die(" Failed to read uploaded SQL file.");
        }

        // Split and run queries
        $queries = array_filter(array_map('trim', explode(';', $sql)));
        $success = 0;
        $fail = 0;

        foreach ($queries as $query) {
            if (!empty($query)) {
                if ($conn->query($query) === TRUE) {
                    $success++;
                } else {
                    echo " Error in query:<br><pre>$query</pre><br>MySQL Error: " . $conn->error . "<br><br>";
                    $fail++;
                }
            }
        }

        $conn->close();
        echo "<hr> Import finished.<br>";
        echo " Successful queries: $success<br>";
        echo " Failed queries: $fail<br>";
    } else {
        echo " No file uploaded or upload error.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload and Import SQL</title>
</head>
<body>
    <h2>Upload SQL File and Import to Database</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="sqlfile" accept=".sql" required />
        <button type="submit">Upload & Import</button>
    </form>
</body>
</html>
