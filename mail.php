<?php
// Include PHPMailer classes
require_once __DIR__ . '/plugins/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/plugins/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/plugins/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class MailHandler {
    private $mail;
    
    public function __construct() {
        $this->mail = new PHPMailer(true);
        $this->configureSMTP();
    }
    
    private function configureSMTP() {
        try {
            // Server settings
            $this->mail->isSMTP();
            $this->mail->Host = 'smtp.gmail.com';
            $this->mail->SMTPAuth = true;
            $this->mail->Username = 'fatuma.omar@strathmore.edu';
            $this->mail->Password = 'upod fivj lurx jbbu';
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $this->mail->Port = 465;
        } catch (Exception $e) {
            error_log("SMTP Configuration Error: " . $e->getMessage());
        }
    }
    
    /**
     * Validate email address
     * @param string $email
     * @return bool
     */
    public function validateEmail($email) {
        // Check if email is valid format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        
        // Additional validation: check if domain exists
        $domain = substr(strrchr($email, "@"), 1);
        if (!checkdnsrr($domain, "MX")) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Send welcome email to new user
     * @param string $userEmail
     * @param string $username
     * @return bool
     */
    public function sendWelcomeEmail($userEmail, $username) {
        try {
            // Validate email first
            if (!$this->validateEmail($userEmail)) {
                throw new Exception("Invalid email address provided");
            }
            
            // Recipients
            $this->mail->setFrom('fatuma.omar@strathmore.edu', 'Alliance School Management');
            $this->mail->addAddress($userEmail, $username);
            
            // Content
            $this->mail->isHTML(true);
            $this->mail->Subject = 'Welcome to student portal';

            // Customized greeting based on user input
            $this->mail->Body = $this->generateWelcomeEmailBody($username);
            $this->mail->AltBody = $this->generateWelcomeEmailTextBody($username);
            
            $this->mail->send();
            return true;
            
        } catch (Exception $e) {
            error_log("Email sending failed: " . $e->getMessage());
            return false;
        }
    }
    
    /**
     * Generate HTML email body with user's customized greeting
     * @param string $username
     * @return string
     */
    private function generateWelcomeEmailBody($username) {
        $clickHereLink = "http://localhost/IAP/verify.php?user=" . urlencode($username);
        
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px;'>
                <h2 style='color: #333; text-align: center;'>Student Verification Portal</h2>

                <div style='background: white; padding: 20px; border-radius: 5px; margin: 20px 0;'>
                    <p><strong>Hello {$username},</strong></p>
                    
                    <p>You requested an account on ICS 2.2</p>
                    
                    <p>In order to use this account you need to <a href='{$clickHereLink}' style='color: #007bff; text-decoration: none;'><strong>Click Here</strong></a> to complete the registration process.</p>
                    
                    <div style='margin: 30px 0; padding: 15px; background-color: #f1f3f4; border-radius: 5px;'>
                        <p style='margin: 0;'><strong>Regards,</strong></p>
                        <p style='margin: 5px 0 0 0;'>Systems Admin</p>
                        <p style='margin: 0;'><strong>ICS 2.2</strong></p>
                    </div>
                </div>
                
                <div style='text-align: center; font-size: 12px; color: #666; margin-top: 20px;'>
                    <p>This is an automated message from the ICS 2.2 system</p>
                </div>
            </div>
        </div>";
    }
    
    /**
     * Generate plain text email body for non-HTML clients
     * @param string $username
     * @return string
     */
    private function generateWelcomeEmailTextBody($username) {
        $clickHereLink = "http://localhost/IAP/verify.php?user=" . urlencode($username);

        return "Welcome to the student verification portal!

Hello {$username},

You requested an account on the Alliance School Management.

In order to use this account you need to click the following link to complete the registration process:
{$clickHereLink}

Regards,
Systems Admin
Alliance School Management

This is an automated message from the Alliance School Management";
    }
}
?>
