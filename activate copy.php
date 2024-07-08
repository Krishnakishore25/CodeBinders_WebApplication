<?php
session_start(); // Start session
require_once __DIR__ . '/db.php';



$message = "Invalid activation request.";
$type = "error";

if (!empty($_GET["token"])) {
    $token = $_GET["token"];
    $conn = require __DIR__ . '/db.php';

    // Check if the token exists and retrieve the associated email and role
    $query = "SELECT Email, role FROM user WHERE activation_token = ? AND status = '0'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($email, $role);
    $stmt->fetch();
    $stmt->close();

    if ($email) {
        // Token is valid, activate the account
        $query = "UPDATE user SET status = '1', activation_token = NULL WHERE Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $message = "Your account is activated.";
            $type = "success";

            // Determine which login page to redirect to
            $login_page = '';
            if ($role == 'candidate') {
                $login_page = "login_candidate.php";
            } elseif ($role == 'interviewer') {
                $login_page = "login_interviewer.php";
            } else {
                // Handle unexpected role (optional)
                $login_page = "login.html"; // Default fallback
            }

            $message .= " <a href='http://localhost/CodeBinders_WebApplication/{$login_page}'>Click here to login.</a>";
        } else {
            $message = "Problem in account activation.";
            $type = "error";
        }
        $stmt->close();
    } else {
        // Invalid token or already activated
        $message = "Invalid activation token or account is already activated.";
        $type = "error";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
</head>
<body>
    <div class="message <?php echo $type; ?>">
        <?php echo $message; ?>
    </div>
</body>
</html>
