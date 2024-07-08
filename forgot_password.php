<?php
// Include database configuration and PHPMailer
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/send_reset_password_link.php'; // Include the activation function file

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    if (!empty($email)) {
        // Check if the email exists in either interviewer or candidate table
        $query = "SELECT I_Email, reset_token FROM interviewer WHERE I_Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result1 = $stmt->get_result();

        $query = "SELECT C_Email, reset_token FROM candidate WHERE C_Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result2 = $stmt->get_result();

        if ($result1->num_rows > 0 || $result2->num_rows > 0) {
            // Email found, proceed to send reset password email
            $reset_token = bin2hex(random_bytes(32)); // Generate a random token

            // Update reset_token in both tables
            $update_query = "UPDATE interviewer SET reset_token = ? WHERE I_Email = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ss", $reset_token, $email);
            $stmt->execute();

            $update_query = "UPDATE candidate SET reset_token = ? WHERE C_Email = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->bind_param("ss", $reset_token, $email);
            $stmt->execute();

            if (sendResetPasswordLink($email, $reset_token)) {
                $message = "Password reset mail sent successfully.Please check your email to reset your password";
                $type = "success";
            } else {
                $message = "Failed to send password reset email. Please contact support.";
                $type = "error";
            }
        } else {
            // Email not found
            $message = "Email not found. Please enter the correct email address used during registration.";
            $type = "error";
        }
    } else {
        // Email is required
        $message = "Email is required.";
        $type = "error";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - Smart Interview Support Method</title>
    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: url('assets/img/laptops.webp') no-repeat center center fixed;
            background-size: cover;
        }

        .card {
            max-width: 400px;
            width: 100%;
            background: rgba(255, 255, 255, 0.9); /* Slight white background with transparency */
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-label {
            font-weight: 500;
        }

        .alert {
            margin-top: 20px;
        }

        .alert-error {
            color: red;
            font-weight: bold;
            margin-top: 10px;
        }  
    </style>
</head>

<body>

    <div class="card">
        <h2 class="text-center mb-4">Forgot Password</h2>
        <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($type); ?> text-center" role="alert">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>
        <form id="forgotPasswordForm" method="post" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Your Email Address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Submit</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>
