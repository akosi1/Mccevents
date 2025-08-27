<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['sqlfile']) && $_FILES['sqlfile']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/';
        $uploadFile = $uploadDir . 'aps.sql';

        // Check file extension
        $ext = pathinfo($_FILES['sqlfile']['name'], PATHINFO_EXTENSION); 
        if (strtolower($ext) !== 'sql') {
            echo " Please upload a .sql file only."; 
            exit;
        }

        if (move_uploaded_file($_FILES['sqlfile']['tmp_name'], $uploadFile)) {
            echo " File uploaded successfully to: " . htmlspecialchars($uploadFile);
        } else {
            echo " Failed to move uploaded file.";
        }
    } else {
        echo " No file uploaded or upload error.";
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Upload SQL File</title>
</head>
<body>
<h2>Upload your event.sql file</h2>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="sqlfile" accept=".sql" required />
    <button type="submit">Upload</button>
</form>
</body>
</html>
