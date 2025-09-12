<?php
echo "<h1>Database System Detection</h1>";

// Check what database system is running
try {
    $pdo = new PDO("mysql:host=localhost;port=3306", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Get version information
    $stmt = $pdo->query("SELECT VERSION() as version");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $version = $result['version'];
    
    echo "<h2>Database Version Information:</h2>";
    echo "<strong>Version String:</strong> " . $version . "<br><br>";
    
    // Determine if it's MySQL or MariaDB
    if (stripos($version, 'mariadb') !== false) {
        echo "🟢 <strong>You are running MariaDB</strong><br>";
        echo "MariaDB is a fork of MySQL and is fully compatible.<br>";
    } else {
        echo "🔵 <strong>You are running MySQL</strong><br>";
        echo "This is the original MySQL database system.<br>";
    }
    
    echo "<hr>";
    
    // Additional server information
    $queries = [
        "SELECT @@version_comment as comment" => "Version Comment",
        "SELECT @@version_compile_os as os" => "Compiled for OS",
        "SELECT @@port as port" => "Running on Port"
    ];
    
    echo "<h3>Additional Information:</h3>";
    foreach ($queries as $query => $label) {
        try {
            $stmt = $pdo->query($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $value = current($result);
            echo "<strong>$label:</strong> $value<br>";
        } catch (Exception $e) {
            echo "<strong>$label:</strong> Unable to retrieve<br>";
        }
    }
    
} catch (PDOException $e) {
    echo "❌ <strong>Cannot connect to database:</strong> " . $e->getMessage() . "<br><br>";
    echo "<strong>This could mean:</strong><br>";
    echo "• MySQL/MariaDB service is not running<br>";
    echo "• No MySQL/MariaDB is installed<br>";
    echo "• Different connection credentials needed<br>";
}

echo "<hr>";

echo "<h2>For Your Application:</h2>";
echo "✅ <strong>Good News:</strong> Whether you have MySQL or MariaDB, your PHP application will work the same way!<br>";
echo "✅ Both use the same PHP extensions (pdo_mysql, mysqli)<br>";
echo "✅ Both use the same SQL syntax<br>";
echo "✅ Your configuration doesn't need to change<br>";

?>
