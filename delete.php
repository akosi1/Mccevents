 <?php
 $file = __DIR__ . '/event.sql';

if (file_exists($file)) {
    if (unlink($file)) {
        echo " File deleted successfully.";
    } else {
        echo " Failed to delete the file.";
    }
} else {
    echo "⚠️\ File does not exist.";
}
?> 
