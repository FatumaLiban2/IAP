<?php
require 'Plugins/PHPMailer/vendor/autoload.php';
require_once 'conf.php';
$directories = ["Forms", "Layouts", "Global"];

spl_autoload_register(function ($className) use ($directories) {
    foreach ($directories as $directory) {
        $filePath = __DIR__ . "/$directory/" . $className . '.php';
        if (file_exists($filePath)) {
            require_once $filePath;
            return;
        }
    }
});


// Create instances of commonly used classes with consistent variable names
// Using StudlyCaps for class names (Forms, Layouts) and $Obj* for instances
$ObjForm = new Forms();
$ObjLayout = new Layouts();

