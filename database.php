<?php
class DatabaseHandler {
    private $pdo;

    public function __construct($db_type, $db_host, $db_user, $db_pass, $db_name, $db_port) {
        $dsn = "$db_type:host=$db_host;port=$db_port;dbname=$db_name";
        try {
            if (!extension_loaded('pdo_pgsql')) {
                throw new Exception("PDO PostgreSQL extension is not installed/enabled.");
            }
            $this->pdo = new PDO($dsn, $db_user, $db_pass, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }

    public function registerUser($username, $first_name, $last_name, $email, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(16));
            $sql = "INSERT INTO students (username, first_name, last_name, email, password, verified, verification_token) VALUES (?, ?, ?, ?, ?, 0, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username, $first_name, $last_name, $email, $hashedPassword, $token]);
            return $token;
        } catch (PDOException $e) {
            echo "User registration failed: " . $e->getMessage();
            return false;
        }
    }

    public function getNumberedUsersList() {
        try {
            $sql = "SELECT id, first_name, last_name, username, email, created_at, verified FROM students ORDER BY created_at ASC";
            $stmt = $this->pdo->query($sql);
            $users = $stmt->fetchAll();
            $numberedUsers = [];
            $counter = 1;
            foreach ($users as $user) {
                $user['number'] = $counter++;
                $numberedUsers[] = $user;
            }
            return $numberedUsers;
        } catch (PDOException $e) {
            echo "Failed to fetch users: " . $e->getMessage();
            return [];
        }
    }

    public function authenticateUser($username, $password) {
        try {
            $sql = "SELECT id, first_name, last_name, username, email, password, verified FROM students WHERE username = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            if ($user && password_verify($password, $user['password'])) {
                if (isset($user['verified']) && !$user['verified']) {
                    return 'not_verified';
                }
                unset($user['password']);
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            echo "Authentication failed: " . $e->getMessage();
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
            echo "Verification failed: " . $e->getMessage();
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