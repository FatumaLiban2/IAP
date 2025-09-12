<?php
// Alternative configuration for MySQL
// Uncomment the database type you want to use

// PostgreSQL Configuration (Original)
/*
$conf['db_type'] = 'pgsql';
$conf['db_host'] = 'localhost';
$conf['db_user'] = 'postgres';
$conf['db_pass'] = 'Asma123';
$conf['db_name'] = 'students';
$conf['db_port'] = '5432';
*/

// MySQL Configuration (Alternative)
$conf['db_type'] = 'mysql';
$conf['db_host'] = 'localhost';
$conf['db_user'] = 'root';  // Default MySQL user
$conf['db_pass'] = '';      // Default MySQL password (empty for XAMPP)
$conf['db_name'] = 'students';
$conf['db_port'] = '3306';  // Default MySQL port

// Site Information
$conf['site_name'] = 'Alliance School Management';
$conf['site_url'] = 'http://localhost';
$conf['admin_email'] = 'fatuma.omar@strathmore.edu';

// Site Language
$conf['site_lang'] = 'en';
?>
