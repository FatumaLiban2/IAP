<?php
// Include the ClassAutoLoad Method
require_once 'ClassAutoLoad.php';
$layout = new layouts(); // Add this line
$layout->header($conf);

if (isset($_GET['user'])) {
    $username = htmlspecialchars($_GET['user']);
    echo "<div style='max-width: 600px; margin: 50px auto; padding: 20px; text-align: center;'>";
    echo "<h2>Account Verification</h2>";
    echo "<p>Thank you <strong>{$username}</strong>!</p>";
    echo "<p>Your account verification is complete.</p>";
    echo "<p><a href='signin.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Continue to Login</a></p>";
    echo "</div>";
} else {
    echo "<div style='max-width: 600px; margin: 50px auto; padding: 20px; text-align: center;'>";
    echo "<h2>Invalid Verification Link</h2>";
    echo "<p>The verification link is invalid or incomplete.</p>";
    echo "<p><a href='index.php'>← Back to Home</a></p>";
    echo "</div>";
}
$layout = new layouts(); // Add this line
$layout->footer($conf);
?>
