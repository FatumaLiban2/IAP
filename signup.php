<?php
require 'ClassAutoLoad.php';
$ObjLayout->header($conf);
$ObjLayout->navbar($conf);
?>
<main class="container py-4">
    <section class="hero-section text-center">
        <h1>Sign Up for <?php echo $conf['site_name']; ?></h1>
        <p class="lead">Create your account below.</p>
    </section>
    <div class="row g-4 mt-4">
        <div class="col-md-6">
            <div class="card card-custom p-4">
                <?php 
                $ObjForm->signup(); 
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
</main>
<?php
$ObjLayout->footer($conf);
?>
