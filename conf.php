<?php
// Site Information
$conf['site_name'] = 'Alliance School Management';
$conf['site_url'] = 'http://localhost';
$conf['admin_email'] = 'fatuma.omar@strathmore.edu';

// Database Configuration - PostgreSQL
define('DB_TYPE', 'pgsql'); // Database type
define('DB_HOST', 'localhost'); // Database host
define('DB_NAME', 'Students'); // Database name
define('DB_USER', 'postgres'); // Database user
define('DB_PASS', 'Asma123'); // Database password
define('DB_PORT', '5432'); // Database port

// SMTP Configuration for email sending
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USER', 'fatuma.omar@strathmore.edu');
define('SMTP_PASS', 'upod fivj lurx jbbu');
define('SMTP_PORT', 465);
define('SMTP_SECURE', 'PHPMailer::ENCRYPTION_STARTTLS');



// Site Language
$conf['site_lang'] = 'en';
