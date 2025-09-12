<?php
// Include the ClassAutoLoad Method
require_once 'ClassAutoLoad.php';
$layout = new layouts();
$form = new forms();
$hello = new classes();
$layout->header($conf);
print $hello->do();
$form->login();
$layout->footer($conf);

