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
     * Send welcome email to new user (Alliance School Management version)
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
            $this->mail->Subject = 'Welcome to Alliance School Management! Account Created';
            $this->mail->Body = "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>"
                . "<div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px;'>"
                . "<h2 style='color: #333; text-align: center;'>Welcome to Alliance School Management</h2>"
                . "<div style='background: white; padding: 20px; border-radius: 5px; margin: 20px 0;'>"
                . "<p><strong>Hello {$username},</strong></p>"
                . "<p>You requested an account on Alliance School Management.</p>"
                . "<p>Your account has been created successfully. You can now log in to your dashboard and access your student portal.</p>"
                . "<div style='margin: 30px 0; padding: 15px; background-color: #f1f3f4; border-radius: 5px;'>"
                . "<p style='margin: 0;'><strong>Regards,</strong></p>"
                . "<p style='margin: 5px 0 0 0;'>Systems Admin</p>"
                . "<p style='margin: 0;'><strong>Alliance School Management</strong></p>"
                . "</div>"
                . "</div>"
                . "<div style='text-align: center; font-size: 12px; color: #666; margin-top: 20px;'>"
                . "<p>This is an automated message from Alliance School Management.</p>"
                . "</div>"
                . "</div>"
                . "</div>";
            $this->mail->AltBody = "Hello {$username},\n\nYou requested an account on Alliance School Management.\n\nYour account has been created successfully. You can now log in to your dashboard and access your student portal.\n\nRegards,\nSystems Admin\nAlliance School Management";
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
        return "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
            <div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px;'>
                <h2 style='color: #333; text-align: center;'>Welcome to Alliance School Management</h2>
                <div style='background: white; padding: 20px; border-radius: 5px; margin: 20px 0;'>
                    <p><strong>Hello {$username},</strong></p>
                    <p>Your account has been created successfully.</p>
                    <div style='margin: 30px 0; padding: 15px; background-color: #f1f3f4; border-radius: 5px;'>
                        <p style='margin: 0;'><strong>Regards,</strong></p>
                        <p style='margin: 5px 0 0 0;'>Alliance School Management Team</p>
                    </div>
                </div>
                <div style='text-align: center; font-size: 12px; color: #666; margin-top: 20px;'>
                    <p>This is an automated message from Alliance School Management</p>
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
    return "Welcome to Alliance School Management!\n\nHello {$username},\n\nYour account has been created successfully.\n\nRegards,\nAlliance School Management Team\n\nThis is an automated message from Alliance School Management";
    }
}
?>
