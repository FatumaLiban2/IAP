
<?php
require_once 'ClassAutoLoad.php';
require_once __DIR__ . '/../conf.php';
class Forms {


    public function signup() {
        global $conf;


        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = trim($_POST['first_name']);
            $last_name  = trim($_POST['last_name']);
            $username   = trim($_POST['username']);
            $email      = trim($_POST['email']);
            $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
            // Connect to database (PostgreSQL)
            $dsn = "pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME;
            $pdo = new PDO($dsn, DB_USER, DB_PASS);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert into DB
            $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$first_name, $last_name, $username, $email, $password])) {
                echo "<p style='color:green;'>Signup successful! You can now sign in.</p>";
                require_once __DIR__ . '/../Global/SendMail.php';
                $mail = new SendMail();
                $mail->sendTestEmail($username, $email);
            } else {
                echo "<p style='color:red;'>Error: could not sign up.</p>";
                $stmt = null;
            }

            $pdo = null;
        }
?>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <?php $this->submit_button('Sign Up', 'signup'); ?>
            <a href='signin.php'>Already have an account? Sign In</a>
        </form>
<?php
    }

    public function signin() {
?>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" class="form-control" name="username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <?php $this->submit_button('Sign In', 'signin'); ?>
            <a href='signup.php'>Don't have an account? Sign Up</a>
        </form>
<?php
    }

    public function submit_button($text, $name) {
        echo "<button type='submit' class='btn btn-primary' name='{$name}'>{$text}</button>";
    }
}