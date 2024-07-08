<?php
session_start(); // Start session
require_once __DIR__ . '/db.php';


$message = "Invalid activation request.";
$type = "error";

if (!empty($_GET["token"])) {
    $token = $_GET["token"];
    $conn = require __DIR__ . '/db.php';

    // Check if the token exists and retrieve the associated email, role, and password
    $query = "SELECT Email, Role, Password FROM user WHERE activation_token = ? AND status = '0'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->bind_result($email, $role, $password);
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

            // Insert data into the appropriate table based on the role
            if ($role == 'Candidate') {
                $insertQuery = "INSERT INTO candidate (C_Email, C_password, status) VALUES (?, ?, 1)";
                $login_page = "login_candidate.html";
            } elseif ($role == 'Interviewer') {
                $insertQuery = "INSERT INTO interviewer (I_Email, I_password, status) VALUES (?, ?, 1)";
                $login_page = "login_interviewer.html";
            }

            if ($insertQuery) {
                $insertStmt = $conn->prepare($insertQuery);
                $insertStmt->bind_param("ss", $email, $password); // Assuming password is stored securely

                if ($insertStmt->execute()) {
                    $message .= " Your role and password have been recorded.";
                } else {
                    $message .= " However, there was an issue recording your role and password.";
                    $type = "error";
                }
                $insertStmt->close();
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

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-image: url('assets/img/activation.jpg');
            background-size: cover;
            background-position: center;
            color: #495057;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .message-container {
            max-width: 600px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .message {
            font-size: 1.2em;
            line-height: 1.6;
            color: #343a40;
        }

        .message.success {
            color: #4f8a10;
        }

        .message.error {
            color: #d8000c;
        }

        .message a {
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
        }

        .message a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="message-container">
        <div class="message <?php echo $type; ?>">
            <?php echo $message; ?>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>
</body>

</html>
