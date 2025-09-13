<?php
require_once __DIR__ . '/database.php';
require_once __DIR__ . '/conf.php';

$db = new DatabaseHandler($conf['db_type'], $conf['db_host'], $conf['db_user'], $conf['db_pass'], $conf['db_name'], $conf['db_port']);
$verified = false;
$message = '';
if (isset($_GET['token'])) {
    $token = $_GET['token'];
    if ($db->verifyUserByToken($token)) {
        $verified = true;
        $message = 'Your account has been verified! You may now <a href="login.php">log in</a>.';
    } else {
        $message = 'Invalid or expired verification link.';
    }
} else {
    $message = 'No verification token provided.';
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Verification</title>
</head>
<body>
    <h1>Account Verification</h1>
    <p><?php echo $message; ?></p>
</body>
</html>
