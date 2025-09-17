<?php
require 'ClassAutoLoad.php';
if (!isset($ObjLayout)) {
	if (isset($ObjLayout)) {
		$ObjLayout = $ObjLayout; // alias existing instance
	} else {
		$ObjLayout = new Layouts();
	}
}
$ObjLayout->header($conf);
$ObjLayout->navbar($conf);
$ObjLayout->banner($conf);
$ObjLayout->content($conf);
$ObjLayout->footer($conf);