<?php
class DatabaseHandler {
    private $db_type;
    private $db_host;
    private $db_user;
    private $db_pass;
    private $db_name;
    private $db_port;
    private $pdo;
    
    public function __construct($db_type, $db_host, $db_user, $db_pass, $db_name, $db_port) {
        $this->db_type = $db_type;
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
        $this->db_port = $db_port;
        
        // Automatically connect when creating the object
        $this->connect();
    }

    public function connect() {
        $dbData = "$this->db_type:host=$this->db_host;port=$this->db_port;dbname=$this->db_name";
        try {
            $this->pdo = new PDO($dbData, $this->db_user, $this->db_pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    
    // ...existing code...
    public function registerUser($username, $first_name, $last_name, $email, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO students (username, first_name, last_name, email, password) VALUES (?, ?, ?, ?, ?)";
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