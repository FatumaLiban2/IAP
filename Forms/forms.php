
<?php

class Forms {


    public function signup() {
        global $conf;

        // Connect to database (PostgreSQL)
        $dsn = "pgsql:host={$conf['db_host']};port={$conf['db_port']};dbname={$conf['db_name']}";
        $pdo = new PDO($dsn, $conf['db_user'], $conf['db_pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $first_name = trim($_POST['first_name']);
            $last_name  = trim($_POST['last_name']);
            $username   = trim($_POST['username']);
            $email      = trim($_POST['email']);
            $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Insert into DB
            $stmt = $pdo->prepare("INSERT INTO students (first_name, last_name, username, email, password) VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$first_name, $last_name, $username, $email, $password])) {
                echo "<p style='color:green;'>Signup successful! You can now sign in.</p>";
                require_once __DIR__ . '/../Global/SendMail.php';
                $ObjSendMail = new SendMail();
                $ObjSendMail->sendVerificationEmail($conf, $username, $email, bin2hex(random_bytes(16)));
            } else {
                echo "<p style='color:red;'>Error: could not sign up.</p>";
            }
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