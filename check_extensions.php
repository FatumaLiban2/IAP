<?php
echo "<h1>PHP Extensions Check</h1>";

echo "<h2>PDO Extensions Status:</h2>";
$required_extensions = ['pdo', 'pdo_pgsql', 'pdo_mysql', 'pgsql'];

foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ <strong>$ext</strong> - LOADED<br>";
    } else {
        echo "❌ <strong>$ext</strong> - NOT LOADED<br>";
    }
}

echo "<hr>";

echo "<h2>All Loaded Extensions:</h2>";
$extensions = get_loaded_extensions();
sort($extensions);
echo "<ul>";
foreach ($extensions as $extension) {
    echo "<li>$extension</li>";
}
echo "</ul>";

echo "<hr>";

echo "<h2>PHP Configuration:</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "PHP Configuration File: " . php_ini_loaded_file() . "<br>";

$additional_inis = php_ini_scanned_files();
if ($additional_inis) {
    echo "Additional INI files: " . $additional_inis . "<br>";
}

?>
