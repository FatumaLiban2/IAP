<?php
class Layouts {
	 public function header($conf) {
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $conf['site_name']; ?></title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
		<style>
			body { background-color: #f8f9fa; }
			.hero-section { background: linear-gradient(135deg, #0d6efd, #6610f2); color: white; padding: 4rem 2rem; border-radius: 1rem; }
			.hero-section h1 { font-weight: 700; }
			.card-custom { border: none; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
			footer { background: #212529; color: #adb5bd; padding: 1.5rem 0; text-align: center; margin-top: 3rem; }
			footer p { margin: 0; }
		</style>
	</head>
<?php
	 }

	 public function navbar($conf) {
?>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
			<div class="container">
				<a class="navbar-brand fw-bold" href="./"><?php echo $conf['site_name']; ?></a>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse" id="navbarNav">
					<ul class="navbar-nav ms-auto">
						<li class="nav-item"><a class="nav-link active" href="./">Home</a></li>
						<li class="nav-item"><a class="nav-link" href="index.php">Sign Up</a></li>
						<li class="nav-item"><a class="nav-link" href="login.php">Sign In</a></li>
					</ul>
				</div>
			</div>
		</nav>
		<main class="container py-4">
<?php
	 }

	 public function banner($conf) {
?>
			<section class="hero-section text-center">
				<h1>Welcome to <?php echo $conf['site_name']; ?></h1>
				<p class="lead">Your platform for learning, growth, and achievement.</p>
				<a href="index.php" class="btn btn-light btn-lg mt-3">Get Started</a>
			</section>
<?php
	 }

	 public function content($conf) {
?>
			<div class="row g-4 mt-4">
				<div class="col-md-6">
					<div class="card card-custom p-4 text-center h-100">
						<h2 class="fw-bold">Track Your Academic Progress</h2>
						<p>Stay motivated by monitoring your academic journey with easy-to-use dashboards and stats.</p>
						<a href="#" class="btn btn-primary">Learn More</a>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card card-custom p-4 text-center h-100">
						<h2 class="fw-bold">Join the School Community</h2>
						<p>Connect with classmates, share your achievements, and grow together.</p>
						<a href="#" class="btn btn-outline-primary">Explore</a>
					</div>
				</div>
			</div>
<?php
	 }

	 public function form_content($conf, $ObjForm) {
?>
			<div class="row g-4 mt-4">
				<div class="col-md-6">
					<div class="card card-custom p-4">
						<?php 
							if (basename($_SERVER['PHP_SELF']) == 'index.php') {
								$ObjForm->signup();
							} else {
								$ObjForm->signin();
							}
						?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="card card-custom p-4 text-center">
						<h2 class="fw-bold">Why Join Alliance School Management?</h2>
						<p>Unlock access to resources, announcements, and a supportive school community.</p>
						<a href="index.php" class="btn btn-success">Enroll Now</a>
					</div>
				</div>
			</div>
<?php
	 }

	 public function footer($conf) {
?>
		</main>
		<footer>
			<div class="container">
				<p>&copy; <?php echo date("Y"); ?> <?php echo $conf['site_name']; ?>. All rights reserved.</p>
			</div>
		</footer>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
	</body>
</html>
<?php
	 }
}
