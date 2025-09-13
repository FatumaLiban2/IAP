
<?php
// IMPORTANT: Make sure 'ClassAutoLoad.php' is included before this file is used.
// It loads 'database.php' and 'mail.php', so the classes 'database' and 'MailHandler' are available.

class forms {
    private $db;
    private $mailHandler;

    public function __construct() {
        try {
            // Initialize database and mail handler
            global $conf;
            $this->mailHandler = new MailHandler();
            $this->db = new DatabaseHandler($conf['db_type'], $conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name'], $conf['db_port']);
        } catch (Exception $e) {
            // Log the error but don't break the page
            error_log("Forms constructor error: " . $e->getMessage());
            // Initialize with null so other methods can handle the error gracefully
            $this->db = null;
            $this->mailHandler = null;
        }
    }

    public function getDatabase() {
        return $this->db;
    }
    
    public function signup() {
        $message = '';
        $messageClass = '';
        
        if ($_POST) {
            $result = $this->processSignup();
            $message = $result['message'];
            $messageClass = $result['success'] ? 'success' : 'error';
            
            // If registration is successful, redirect to login page after a brief delay
            if ($result['success']) {
                echo '<script>
                    setTimeout(function() {
                        window.location.href = "login.php";
                    }, 3000);
                </script>';
            }
        }
?>
    
    <?php if ($message): ?>
        <p><strong><?php echo $messageClass === 'success' ? 'SUCCESS:' : 'ERROR:'; ?></strong> <?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    
    <form method="post" action="">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>">
        <br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>">
        <br><br>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        <br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        <br><br>
        <input type="submit" value="Sign Up"> <a href="login.php">
             <br><br> Already have an account?&nbsp &nbsp Log in</a>
    </form>
    <br><br>
<?php
    }
    
    private function processSignup() {
        // Check if database connection is available
        if ($this->db === null) {
            return ['success' => false, 'message' => 'Database connection error. Please try again later.'];
        }
        if ($this->mailHandler === null) {
            return ['success' => false, 'message' => 'Email service error. Please try again later.'];
        }
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $email = trim($_POST['email']);
        // Validate inputs
        if (empty($firstName) || empty($lastName) || empty($username) || empty($password) || empty($email)) {
            return ['success' => false, 'message' => 'All fields are required.'];
        }
        // Validate email format and domain
        if (!$this->mailHandler->validateEmail($email)) {
            return ['success' => false, 'message' => 'Invalid email address or domain does not exist.'];
        }
        // Check if user already exists
        if ($this->db->userExists($username)) {
            return ['success' => false, 'message' => 'Username already exists.'];
        }
        if ($this->db->emailExists($email)) {
            return ['success' => false, 'message' => 'Email address already registered.'];
        }
        // Register user and get token
        $token = $this->db->registerUser($username, $firstName, $lastName, $email, $password);
        if ($token && is_string($token)) {
            // Send verification email
            if ($this->mailHandler->sendVerificationEmail($email, $username, $token)) {
                return ['success' => true, 'message' => 'Registration successful! A verification email has been sent to your inbox. Please check your email and click the link to activate your account.'];
            } else {
                return ['success' => true, 'message' => 'Registration successful! However, there was an issue sending the verification email.'];
            }
        } else {
            return ['success' => false, 'message' => 'Registration failed. Please try again.'];
        }
    }
    public function login() {
        $message = '';
        $messageClass = '';
        
        if ($_POST) {
            $result = $this->processLogin();
            $message = $result['message'];
            $messageClass = $result['success'] ? 'success' : 'error';
            
            if ($result['success']) {
                // Redirect to dashboard on successful login
                header('Location: dashboard.php');
                exit();
            }
        }
        ?>
        
        <?php if ($message): ?>
            <p><strong><?php echo $messageClass === 'success' ? 'SUCCESS:' : 'ERROR:'; ?></strong> <?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        
        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            <br><br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br><br>
            <input type="submit" value="Log In"> <a href="./"> Don't have an account? &nbsp &nbsp Sign up</a>
        </form>
        <?php
    }
    
    private function processLogin() {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        if (empty($username) || empty($password)) {
            return ['success' => false, 'message' => 'Username and password are required.'];
        }
        $user = $this->db->authenticateUser($username, $password);
        if ($user && is_array($user)) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            return ['success' => true, 'message' => 'Login successful!'];
        } elseif ($user === 'not_verified') {
            return ['success' => false, 'message' => 'Account not verified. Please check your email and click the verification link.'];
        } else {
            return ['success' => false, 'message' => 'Invalid username or password.'];
        }
    }
    
    /**
     * Display numbered list of users who have signed up
     */
    public function displayUsersList() {
        $users = $this->db->getNumberedUsersList();
        
        if (empty($users)) {
            echo "<p>No users have signed up yet.</p>";
            return;
        }
        
        echo "<h2>Registered Users</h2>";
        echo "<ol>";
        
        foreach ($users as $user) {
            $formattedDate = date('M j, Y g:i A', strtotime($user['created_at']));
            
            echo "<li>";
            echo htmlspecialchars($user['username']) . " ";
            echo "(" . htmlspecialchars($user['email']) . ") ";
            echo "- Registered: " . $formattedDate . " ";
            
            echo "</li>";
        }
        
        echo "</ol>";
        echo "<p>Total Users: " . count($users) . "</p>";
    }
}
