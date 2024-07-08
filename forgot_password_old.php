<?php
// Include database configuration and PHPMailer
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/send_reset_password_link.php'; // Include the activation function file

// Ensure the necessary columns exist in the user table
$conn = require __DIR__ . '/db.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    if (!empty($name) && !empty($email)) {
        $query = "SELECT I_Email, reset_token FROM interviewer WHERE I_Email = '$email' 
                  UNION 
                  SELECT C_Email, reset_token FROM candidate WHERE C_Email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $reset_token = bin2hex(random_bytes(32)); // Generate a random token

                $update_query = "UPDATE interviewer SET reset_token = '$reset_token' WHERE I_Email = '$email'";
                $update_query .= " ; UPDATE candidate SET reset_token = '$reset_token' WHERE C_Email = '$email'";
                
                if (mysqli_multi_query($conn, $update_query)) {
                    if (sendResetPasswordLink($_POST["email"], $reset_token)) {
                        $message = "Password reset mail sent successfully";
                        $type = "success";
                    } else {
                        $message = "Failed to send password reset email. Please contact support.";
                        $type = "danger";
                    }
                } else {
                    $message = "Error: " . mysqli_error($conn);
                    $type = "danger";
                }
            } else {
                $message = "Email not found. Please enter the correct email address.";
                $type = "warning";
            }
        } else {
            $message = "Error: " . mysqli_error($conn);
            $type = "danger";
        }
    } else {
        $message = "Name and email are required.";
        $type = "warning";
    }
}

// Close connection
mysqli_close($conn);
?>
