<?php

    require_once __DIR__ . '/database.php';
    require_once __DIR__ . '/conf.php';

    try {
        $db = new DatabaseHandler($conf['db_type'], $conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name'], $conf['db_port']);
        $connection = $db->connect();
        echo "Database connection successful!<br>";
        
        // Debug: Check if connection is null
        if ($connection === null) {
            echo "ERROR: Connection is null!<br>";
        } else {
            echo "Connection object type: " . get_class($connection) . "<br>";
            
            // Test query
            $stmt = $connection->prepare("SELECT * FROM students");
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo "Query successful! Results:<br>";
            print_r($results);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
