<?php
echo "<h1>Find PHP Configuration File</h1>";
echo "<strong>PHP Configuration File Location:</strong><br>";
echo php_ini_loaded_file() . "<br><br>";

echo "<strong>Additional INI files:</strong><br>";
$additional = php_ini_scanned_files();
if ($additional) {
    echo $additional;
} else {
    echo "None found";
}

echo "<hr>";
echo "<h2>Current PHP Info</h2>";
echo "To see full PHP configuration, visit: <a href='phpinfo.php'>phpinfo.php</a>";
?>
