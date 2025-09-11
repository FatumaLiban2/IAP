<?php
session_start(); // Start session for user authentication
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

// Include additional required files
require_once 'database.php';
require_once 'mail.php';

// create an instance of classes
$objhello = new classes();
$objform = new forms();
$objlayout = new layouts();

