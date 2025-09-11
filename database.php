<?php
class DatabaseHandler {
    private $pdo;
    
    public function __construct($config) {
        try {
            // PostgreSQL DSN for Students database
            $dsn = "pgsql:host={$config['db_host']};port={$config['db_port']};dbname=Students";
            $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Create students table if it doesn't exist
            $this->createStudentsTable();
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    
    private function createStudentsTable() {
        // PostgreSQL syntax - uses SERIAL and BOOLEAN
        $sql = "CREATE TABLE IF NOT EXISTS students (
            id SERIAL PRIMARY KEY,
            username VARCHAR(50) UNIQUE NOT NULL,            first_name VARCHAR(50) NOT NULL,
            
            first_name VARCHAR(50) NOT NULL,
            last_name VARCHAR(50) NOT NULL,
            email VARCHAR(100) UNIQUE NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            verified BOOLEAN DEFAULT FALSE
        )";
        $this->pdo->exec($sql);
    }

    // ...existing code...
    public function registerUser($username, $first_name, $last_name, $email, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO students (username, first_name, last_name, email, password) VALUES ($1, $2, $3, $4, $5)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $first_name, $last_name, $email, $hashedPassword]);
            return true;
        } catch (PDOException $e) {
            error_log("User registration failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function getNumberedUsersList() {
        try {
            $sql = "SELECT id, first_name, last_name, username, email, created_at, verified FROM students ORDER BY created_at ASC";
            $stmt = $this->pdo->query($sql);
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // Add numbering to the results
            $numberedUsers = [];
            $counter = 1;
            foreach ($users as $user) {
                $user['number'] = $counter++;
                $numberedUsers[] = $user;
            }
            return $numberedUsers;
        } catch (PDOException $e) {
            error_log("Failed to fetch users: " . $e->getMessage());
            return [];
        }
    }
    
    public function authenticateUser($username, $password) {
        try {
            $sql = "SELECT id, first_name, last_name, username, email, password FROM students WHERE username = $1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                unset($user['password']); // Don't return password
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Authentication failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function userExists($username) {
        try {
            $sql = "SELECT COUNT(*) FROM students WHERE username = $1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function emailExists($email) {
        try {
            $sql = "SELECT COUNT(*) FROM students WHERE email = $1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>