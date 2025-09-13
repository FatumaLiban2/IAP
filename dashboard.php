<?php
// DB connection using PDO for PostgreSQL
try {
    $conn = new PDO("pgsql:host=localhost;port=5432;dbname=Students", "postgres", "Asma123");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get users in ascending order
    $sql = "SELECT username FROM students ORDER BY username ASC";
    $stmt = $conn->query($sql);

    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($users) {
        echo "<ol>"; // ordered list for numbering
        foreach ($users as $row) {
            echo "<li>" . htmlspecialchars($row['username']) . "</li>";
        }
        echo "</ol>";
    } else {
        echo "No users found.";
    }
    $conn = null; // Close connection
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>