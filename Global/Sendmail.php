<?php
// filepath: c:\Apache24\htdocs\IAP\Global\Sendmail.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

class SendMail {
    
    // Simple test email function
    public function sendTestEmail($username, $userEmail) {
        try {
            $mail = new PHPMailer(true);
            
            // SMTP settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'fatuma.omar@strathmore.edu';
            $mail->Password = 'upod fivj lurx jbbu';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            
            // Email content
            $mail->setFrom('fatuma.omar@strathmore.edu', 'Alliance School Management');
            $mail->addAddress($userEmail, $username);
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Alliance School Management';
            
            $mail->Body = "
            <h2>Welcome!</h2>
            <p>Hello <strong>{$username}</strong>,</p>
            <p>Your account has been created successfully.</p>
            <p>Thank you for joining Alliance School Management!</p>
            ";
            
            $mail->AltBody = "Hello {$username}, Your account has been created successfully. Thank you!";
            
            $mail->send();
            echo "<p style='color:green;'>Test email sent successfully to {$userEmail}!</p>";
            return true;
            
        } catch (Exception $e) {
            echo "<p style='color:red;'>Email failed: " . $e->getMessage() . "</p>";
            return false;
        }
    }
}