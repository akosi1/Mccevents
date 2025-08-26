<?php
// Change permissions on storage and bootstrap/cache recursively
function chmod_r($path, $filemode) {
    if (!is_dir($path)) {
        return chmod($path, $filemode);
    }
    $dh = opendir($path);
    while (($file = readdir($dh)) !== false) {
        if($file != '.' && $file != '..') {
            $fullpath = $path.'/'.$file;
            if(is_link($fullpath)) {
                return false;
            } elseif(!is_dir($fullpath)) {
                if (!chmod($fullpath, $filemode)) {
                    return false;
                }
            } else {
                if (!chmod_r($fullpath, $filemode)) {
                    return false;
                }
            }
        }
    }
    closedir($dh);
    return chmod($path, $filemode);
}

chmod_r(__DIR__.'/storage', 0775);
chmod_r(__DIR__.'/bootstrap/cache', 0775);

echo "Permissions set!";
?>
