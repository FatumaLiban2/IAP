<?php
require 'ClassAutoLoad.php';

// Ensure objects exist with consistent casing
// Autoloader currently creates $objlayout (lowercase); standardize to $ObjLayout
if (!isset($ObjLayout)) {
	if (isset($objlayout)) {
		$ObjLayout = $objlayout; // alias existing instance
	} else {
		$ObjLayout = new Layouts();
	}
}

$ObjLayout->header($conf);
$ObjLayout->navbar($conf);
$ObjLayout->banner($conf);
$ObjLayout->content($conf);
$ObjLayout->footer($conf);