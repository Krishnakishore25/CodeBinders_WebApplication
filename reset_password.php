<?php
// Start session to store success message
session_start();

// Include your database connection file here
include 'db.php';

// Assuming you have already established a database connection
$servername = "localhost"; // Change this to your server name
$username = "root"; // Change this to your database username
$password = ""; // Change this to your database password
$database = "interviewsupportsystem"; // Change this to your database name

// Create connection
$connection = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";
$type = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password and confirm password
    if ($password !== $confirm_password) {
        $message = "Passwords do not match.";
        $type = "error";
    } elseif (strlen($password) < 8) {
        $message = "Password must be at least 8 characters long.";
        $type = "error";
    } elseif (!preg_match("/[A-Za-z]/", $password) || !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $password)) {
        $message = "Password must include at least one letter and one symbol.";
        $type = "error";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Update password in the database
        $token = isset($_GET['token']) ? $_GET['token'] : '';

        // Update password in the database based on reset token
        $update_query = "UPDATE interviewer SET I_password = '$hashed_password', reset_token = NULL WHERE reset_token = '$token'";
        $update_query .= " ; UPDATE candidate SET C_password = '$hashed_password', reset_token = NULL WHERE reset_token = '$token'";
        
        if (mysqli_multi_query($connection, $update_query)) {
            // Password updated successfully
            $_SESSION['success_message'] = "Password updated successfully.";
            mysqli_close($connection);
            header("Location: beforelogin.html");
            exit;
        } else {
            $message = "Error updating password: " . mysqli_error($connection);
            $type = "error";
        }
    }
}

// Close connection
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Reset Password - Smart Interview Support Method</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700&family=Raleway:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- Custom CSS -->
  <style>
    body, html {
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f8f9fa;
      background: url('assets/img/laptops.webp') no-repeat center center fixed;
      background-size: cover;
    }
    .reset-password-container {
      max-width: 600px;
      width: 100%;
      background: rgba(255, 255, 255, 0.9); /* Slight white background with transparency */
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      padding: 2rem;
    }
    .card {
      width: 100%;
    }
    .alert-error {
      color: red; /* Set the color to red for error messages */
      font-weight: bold;
      margin-top: 10px;
    }
  </style>

  <!-- =======================================================
  * Template Name: Smart Interview Support Method
  * Template URL: https://bootstrapmade.com/Smart Interview Support Method-bootstrap-business-template/
  * Updated: Mar 17 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="page-reset-password">

  <div class="reset-password-container">
    <div class="card p-4">
      <h2 class="text-center mb-4">Reset Password</h2>
      <?php if (!empty($message)): ?>
        <div class="alert alert-<?php echo htmlspecialchars($type); ?> text-center" role="alert">
          <?php echo htmlspecialchars($message); ?>
        </div>
      <?php endif; ?>
      <form id="resetPasswordForm" method="post" action="">
        <div class="mb-3">
          <label for="password" class="form-label">New Password</label>
          <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirm New Password</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Submit</button>
      </form>
    </div>
  </div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
