<?php
// Include the ClassAutoLoad Method
require_once 'ClassAutoLoad.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

$layout->header($conf);
?>

<div style="max-width: 1000px; margin: 0 auto; padding: 20px;">
    <h1>Dashboard - Welcome <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    
    <div style="margin: 20px 0; padding: 15px; background-color: #f8f9fa; border-radius: 5px;">
        <h3>User Information</h3>
        <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['email']); ?></p>
        <p><a href="logout.php" style="color: #161616ff;">Logout</a></p>
    </div>
    
    <div style="margin: 20px 0; padding: 15px; background-color: #e9f7ef; border-radius: 5px;">
        <h3>Progress Report</h3>
        <table style="width:100%; border-collapse: collapse;">
            <tr style="background-color: #d4efdf;">
                <th style="padding: 8px; border: 1px solid #ccc;">Subject</th>
                <th style="padding: 8px; border: 1px solid #ccc;">Grade</th>
                <th style="padding: 8px; border: 1px solid #ccc;">Remarks</th>
            </tr>
            <!-- Example data, replace with dynamic data as needed -->
            <tr>
                <td style="padding: 8px; border: 1px solid #ccc;">Mathematics</td>
                <td style="padding: 8px; border: 1px solid #ccc;">A</td>
                <td style="padding: 8px; border: 1px solid #ccc;">Excellent</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ccc;">English</td>
                <td style="padding: 8px; border: 1px solid #ccc;">B+</td>
                <td style="padding: 8px; border: 1px solid #ccc;">Very Good</td>
            </tr>
        </table>
        <p style="margin-top: 10px;">For more details, contact your class teacher.</p>
    </div>
    
    <div style="margin: 20px 0;">
        <p><a href="index.php">← Back to Home</a></p>
    </div>
</div>

<?php
$layout->footer($conf);
?>