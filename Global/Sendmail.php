
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/plugins/PHPMailer/vendor/autoload.php';

class SendMail {
    // Email validation retained from your original code
    public function validateEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        $domain = substr(strrchr($email, "@"), 1);
        if (!checkdnsrr($domain, "MX")) {
            return false;
        }
        return true;
    }

    // Send verification email, SMTP config from $conf, branding retained
    public function sendVerificationEmail($conf, $username, $userEmail, $token) {
        try {
            if (!$this->validateEmail($userEmail)) {
                throw new Exception("Invalid email address provided");
            }
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = $conf['smtp_host'];
            $mail->SMTPAuth = true;
            $mail->Username = $conf['smtp_user'];
            $mail->Password = $conf['smtp_pass'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $conf['smtp_port'];
            $mail->setFrom($conf['smtp_user'], 'Alliance School Management');
            $mail->addAddress($userEmail, $username);
            $mail->isHTML(true);
            $mail->Subject = 'Welcome to Alliance School Management Account Verification';
            $verifyUrl = $conf['site_url'] . '/verify.php?token=' . urlencode($token);
            $mail->Body = "<div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>"
                . "<div style='background-color: #f8f9fa; padding: 20px; border-radius: 8px;'>"
                . "<h2 style='color: #333; text-align: center;'>Welcome to Alliance School Management Account Verification</h2>"
                . "<div style='background: white; padding: 20px; border-radius: 5px; margin: 20px 0;'>"
                . "<p>Hello <strong>{$username}</strong>,</p>"
                . "<p>You requested an account on Alliance School Management.</p>"
                . "<p>In order to use this account you need to <a href='" . $verifyUrl . "'>Click Here</a> to complete the registration process.</p>"
                . "<br>"
                . "<p>Regards,<br>Systems Admin<br>Alliance School Management</p>"
                . "</div>"
                . "<div style='text-align: center; font-size: 12px; color: #666; margin-top: 20px;'>"
                . "<p>This is an automated message from Alliance School Management.</p>"
                . "</div>"
                . "</div>"
                . "</div>";
            $mail->AltBody = "Hello {$username},\n\nYou requested an account on Alliance School Management.\n\nIn order to use this account you need to visit the following link to complete the registration process: " . $verifyUrl . "\n\nRegards,\nSystems Admin\nAlliance School Management";
            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Email sending failed: {$mail->ErrorInfo}";
            return false;
        }
    }
}
