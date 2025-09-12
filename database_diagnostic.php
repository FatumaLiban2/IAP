<?php
echo "<h1>Database Diagnostic Tool</h1>";
echo "<hr>";

// Step 1: Check if required files exist
echo "<h2>1. File Dependencies Check</h2>";
$required_files = ['database.php', 'conf.php'];
foreach ($required_files as $file) {
    if (file_exists(__DIR__ . '/' . $file)) {
        echo "✅ $file exists<br>";
    } else {
        echo "❌ $file is missing<br>";
    }
}
echo "<hr>";

// Step 2: Load configuration
echo "<h2>2. Configuration Check</h2>";
try {
    require_once __DIR__ . '/conf.php';
    echo "✅ Configuration loaded successfully<br>";
    echo "Database Type: " . $conf['db_type'] . "<br>";
    echo "Database Host: " . $conf['db_host'] . "<br>";
    echo "Database Name: " . $conf['db_name'] . "<br>";
    echo "Database Port: " . $conf['db_port'] . "<br>";
    echo "Database User: " . $conf['db_user'] . "<br>";
} catch (Exception $e) {
    echo "❌ Configuration error: " . $e->getMessage() . "<br>";
}
echo "<hr>";

// Step 3: Check PHP extensions
echo "<h2>3. PHP Extensions Check</h2>";
$required_extensions = ['pdo', 'pdo_pgsql'];
foreach ($required_extensions as $ext) {
    if (extension_loaded($ext)) {
        echo "✅ $ext extension is loaded<br>";
    } else {
        echo "❌ $ext extension is NOT loaded<br>";
    }
}
echo "<hr>";

// Step 4: Test database connection
echo "<h2>4. Database Connection Test</h2>";
try {
    require_once __DIR__ . '/database.php';
    
    echo "Attempting to create DatabaseHandler...<br>";
    $db = new DatabaseHandler($conf['db_type'], $conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name'], $conf['db_port']);
    echo "✅ DatabaseHandler created successfully<br>";
    
    echo "Attempting to get connection...<br>";
    $connection = $db->connect();
    
    if ($connection === null) {
        echo "❌ Connection is null<br>";
    } else {
        echo "✅ Database connection successful!<br>";
        echo "Connection type: " . get_class($connection) . "<br>";
        
        // Test basic query
        echo "Testing basic query...<br>";
        $stmt = $connection->query("SELECT version()");
        $version = $stmt->fetchColumn();
        echo "✅ Database version: " . $version . "<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    echo "Error details: " . $e->getTraceAsString() . "<br>";
}
echo "<hr>";

// Step 5: Test specific table access
echo "<h2>5. Table Access Test</h2>";
if (isset($connection) && $connection !== null) {
    try {
        // Check if students table exists
        $stmt = $connection->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'public' AND table_name = 'students'");
        $table_exists = $stmt->fetch();
        
        if ($table_exists) {
            echo "✅ 'students' table exists<br>";
            
            // Get table structure
            $stmt = $connection->query("SELECT column_name, data_type FROM information_schema.columns WHERE table_name = 'students' ORDER BY ordinal_position");
            $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "Table structure:<br>";
            echo "<ul>";
            foreach ($columns as $column) {
                echo "<li>" . $column['column_name'] . " (" . $column['data_type'] . ")</li>";
            }
            echo "</ul>";
            
            // Count records
            $stmt = $connection->query("SELECT COUNT(*) FROM students");
            $count = $stmt->fetchColumn();
            echo "Number of records in students table: " . $count . "<br>";
            
        } else {
            echo "❌ 'students' table does not exist<br>";
        }
        
    } catch (Exception $e) {
        echo "❌ Table access error: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Cannot test table access - no database connection<br>";
}
echo "<hr>";

// Step 6: PHP and Server Info
echo "<h2>6. PHP and Server Information</h2>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "Current Time: " . date('Y-m-d H:i:s') . "<br>";

?>
