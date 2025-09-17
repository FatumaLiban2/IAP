

<?php
session_start();
require 'ClassAutoLoad.php';

// Handle login form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['signin'])) {
	$username = trim($_POST['username']);
	$password = $_POST['password'];
	$dsn = "pgsql:host={$conf['db_host']};port={$conf['db_port']};dbname={$conf['db_name']}";
	$pdo = new PDO($dsn, $conf['db_user'], $conf['db_pass']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo->prepare("SELECT * FROM students WHERE username = ?");
	$stmt->execute([$username]);
	$user = $stmt->fetch(PDO::FETCH_ASSOC);
	if ($user && password_verify($password, $user['password'])) {
		$_SESSION['username'] = $user['username'];
		$_SESSION['student_id'] = $user['id'] ?? null;
		header('Location: dashboard.php');
		exit;
	} else {
		$login_error = "Invalid username or password.";
	}
}

$ObjLayout->header($conf);
$ObjLayout->navbar($conf);
$ObjLayout->banner($conf);
if (isset($login_error)) {
	echo '<div class="alert alert-danger text-center">' . htmlspecialchars($login_error) . '</div>';
}
$ObjLayout->form_content($conf, $ObjForm);
$ObjLayout->footer($conf);
?>

