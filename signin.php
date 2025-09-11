<?php
// Include the ClassAutoLoad Method
require_once 'ClassAutoLoad.php';
$layout = new layouts();
$layout->header($conf);
if (isset($hello)) print $hello->do();
if (isset($form)) $form->login();
$layout->footer($conf);