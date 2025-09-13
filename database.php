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
            
            // Check and add missing columns: password, verified, verification_token
            $columns = [
                'password' => "ALTER TABLE students ADD COLUMN password TEXT NOT NULL DEFAULT ''",
                'verified' => "ALTER TABLE students ADD COLUMN verified INTEGER NOT NULL DEFAULT 0",
                'verification_token' => "ALTER TABLE students ADD COLUMN verification_token TEXT"
            ];
            foreach ($columns as $col => $sql) {
                $stmt = $this->pdo->query("SELECT column_name FROM information_schema.columns WHERE table_name = 'students' AND column_name = '".$col."'");
                if (!$stmt->fetch()) {
                    $this->pdo->exec($sql);
                    if ($col === 'password') {
                        $default_password = password_hash('password123', PASSWORD_DEFAULT);
                        $stmt2 = $this->pdo->prepare("UPDATE students SET password = ? WHERE password = '' OR password IS NULL");
                        $stmt2->execute([$default_password]);
                    }
                }
            }
            return $this->pdo;
        } catch (PDOException $e) {
            error_log("Database connection failed: " . $e->getMessage());
            throw new Exception("Database connection failed: " . $e->getMessage());
        }
    }
    
    
    // ...existing code...
    public function registerUser($username, $first_name, $last_name, $email, $password) {
        try {
            error_log("Registration attempt - Username: " . var_export($username, true) . 
                     ", First: " . var_export($first_name, true) . 
                     ", Last: " . var_export($last_name, true) . 
                     ", Email: " . var_export($email, true));
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(16));
            $sql = "INSERT INTO students (username, first_name, last_name, email, password, verified, verification_token) VALUES (?, ?, ?, ?, ?, 0, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $first_name, $last_name, $email, $hashedPassword, $token]);
            return $token;
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
            $sql = "SELECT id, first_name, last_name, username, email, password, verified FROM students WHERE username = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user && password_verify($password, $user['password'])) {
                if (isset($user['verified']) && !$user['verified']) {
                    return 'not_verified';
                }
                unset($user['password']);
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            error_log("Authentication failed: " . $e->getMessage());
            return false;
        }
    }
    public function verifyUserByToken($token) {
        try {
            $sql = "UPDATE students SET verified = 1, verification_token = NULL WHERE verification_token = ? AND verified = 0";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$token]);
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Verification failed: " . $e->getMessage());
            return false;
        }
    }
    
    public function userExists($username) {
        try {
            $sql = "SELECT COUNT(*) FROM students WHERE username = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
    public function emailExists($email) {
        try {
            $sql = "SELECT COUNT(*) FROM students WHERE email = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$email]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }
}
?>