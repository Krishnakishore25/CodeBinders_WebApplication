<?php
session_start(); // Start session
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db.php';


$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        $errors[] = "Incomplete form submission. Please fill in both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT C_password, status FROM candidate WHERE C_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['status'] == 1) {

                if (password_verify($password, $row['C_password'])) {
                    // Password is correct
                    $_SESSION['email'] = $email;
                    $_SESSION['role'] = 'Candidate'; // Store role for future use if needed

                    header("Location: applyforjob.html");
                    exit();
                } else {
                    // Password is incorrect
                    $errors[] = "Password is incorrect.";
                }
            } else {
                $errors[] = "Inactive account.";
            }
        } else {
            $errors[] = "Email is incorrect.";
        }

        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Smart Interview Support Method - Login</title>
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
      background: url('assets/img/laptops.webp') no-repeat center center fixed;
      background-size: cover;
    }
    .login-container {
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
    .error-message {
      color: red;
      font-weight: bold;
      text-align: left;
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

<body class="page-login">

  <div class="login-container">
    <div class="card p-4">
      <div class="text-center mb-4">
        <h2>Not registered yet?</h2>
        <div class="text-center">
          <a href="registration.html">registration</a>
        </div>
      </div>
      <h2 class="text-center mb-4">Login</h2>
      <form id="loginForm" method="post" action="login_candidate.php">
        <div class="message-container mb-3">
          <?php
          if (!empty($errors)) {
              foreach ($errors as $error) {
                  echo '<div class="error-message">' . $error . '</div>';
              }
          }
          ?>
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3 text-center">
          <a href="forgot_password.php">Forgotten Password?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
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

