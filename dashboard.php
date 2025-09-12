<?php
// Include the ClassAutoLoad Method
require_once 'ClassAutoLoad.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit();
}

// Instantiate forms class for database access
$form = new forms();
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
        <h3>First 5 Registered Students</h3>
        <table style="width:100%; border-collapse: collapse;">
            <tr style="background-color: #d4efdf;">
                <th style="padding: 8px; border: 1px solid #ccc;">#</th>
                <th style="padding: 8px; border: 1px solid #ccc;">First Name</th>
                <th style="padding: 8px; border: 1px solid #ccc;">Last Name</th>
                <th style="padding: 8px; border: 1px solid #ccc;">Username</th>
                <th style="padding: 8px; border: 1px solid #ccc;">Email</th>
            </tr>
            <?php
            $users = $form->db->getNumberedUsersList();
            $count = 0;
            foreach ($users as $user) {
                if ($count >= 5) break;
                echo '<tr>';
                echo '<td style="padding: 8px; border: 1px solid #ccc;">' . ($count + 1) . '</td>';
                echo '<td style="padding: 8px; border: 1px solid #ccc;">' . htmlspecialchars($user['first_name']) . '</td>';
                echo '<td style="padding: 8px; border: 1px solid #ccc;">' . htmlspecialchars($user['last_name']) . '</td>';
                echo '<td style="padding: 8px; border: 1px solid #ccc;">' . htmlspecialchars($user['username']) . '</td>';
                echo '<td style="padding: 8px; border: 1px solid #ccc;">' . htmlspecialchars($user['email']) . '</td>';
                echo '</tr>';
                $count++;
            }
            if ($count === 0) {
                echo '<tr><td colspan="5" style="padding: 8px; border: 1px solid #ccc; text-align:center;">No students found.</td></tr>';
            }
            ?>
        </table>
    </div>
    
    <div style="margin: 20px 0;">
        <p><a href="index.php">← Back to Home</a></p>
    </div>
</div>

<?php
$layout->footer($conf);
?>