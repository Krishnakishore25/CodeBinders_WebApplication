<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}



include 'dbuser.php'; // Include the database connection script
$conn = connectDB(); // Function to establish database connection

// Fetch user details
$email = $_SESSION['email'];

// Prepare SQL query to fetch user details and interviewer details
$user_query = "SELECT u.First_Name, u.Last_Name, u.Email, i.phone_number, i.linkedin_profile, i.preferred_communication
               FROM user u
               LEFT JOIN interviewer i ON u.Email = i.I_Email
               WHERE u.Email = ?";
$stmt = $conn->prepare($user_query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Debugging: Check if query executed successfully
if (!$result) {
    echo "Error executing query: " . $conn->error;
    exit();
}

// Initialize variables
$first_name = "";
$last_name = "";
$user_email = "";
$phone_number = "";
$linkedin_profile = "";
$preferred_communication = "";

// Debugging: Check if rows are fetched
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    // Extract user details
    $first_name = $row['First_Name'];
    $last_name = $row['Last_Name'];
    $user_email = $row['Email']; // User's email from 'user' table
    // Extract interviewer details (if they exist)
    $phone_number = $row['phone_number'];
    $linkedin_profile = $row['linkedin_profile'];
    $preferred_communication = $row['preferred_communication'];

    // You can format or manipulate the data here as needed
} else {
    echo "No user found with this email.";
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Interviewer Profile</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">    
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Fonts - Montserrat and Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Reset and base styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            line-height: 1.6;
            background: linear-gradient(135deg, #ffffff, #f2f6fc);
            color: #495057;
        }

        .btn-modern {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px 30px;
            font-size: 1.1rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            border-radius: 50px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            text-align: center;
            margin-bottom: 20px;
            text-decoration: none;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-modern:focus {
            outline: none;
            box-shadow: 0 0 0 4px rgba(37, 117, 252, 0.4);
        }

        .jumbotron {
            background-image: url('assets/img/darkbackground.jpg');
            background-size: cover;
            background-position: center;
            padding: 100px 0;
            text-align: center;
            border-radius: 0;
            margin-bottom: 40px;
            color: #fff;
        }

        .jumbotron h2 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .jumbotron p {
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .features {
            background-color: #fff;
            padding: 60px 0;
        }

        .feature-item {
            text-align: center;
            margin-bottom: 40px;
        }

        .feature-item i {
            font-size: 3rem;
            color: #2575fc;
            margin-bottom: 15px;
        }

        .feature-item h3 {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .feature-item p {
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
            border: 1px solid #e9ecef;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Open Sans', sans-serif;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            margin-bottom: 10px;
        }

        .header-title {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #ffffff;
        }

        .header-title h1{
            color: #ffffff;
        }

        /* Profile section styles */
        .profile-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border: 1px solid #dee2e6;
        }

        .section-title {
    font-size: 22px;
    font-weight: 600;
    margin-bottom: 15px;
    padding-bottom: 10px;
    background: linear-gradient(to right, #6a0dad, #007bff); /* Gradient background from purple to blue */
    -webkit-background-clip: text; /* Clip background to text */
    -webkit-text-fill-color: transparent; /* Hide original text color */
    border-bottom: 2px solid #6a0dad; /* Solid blue border bottom */
}


        .profile-info {
            margin-bottom: 20px;
        }

        .profile-info h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .profile-info p {
            font-size: 16px;
            margin-bottom: 5px;
            word-wrap: break-word; /* Ensure long URLs wrap within container */
        }

        /* Button styles */
        .btn {
            display: inline-block;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            .section-title {
                font-size: 20px;
            }
            .profile-info h3 {
                font-size: 16px;
            }
            .profile-info p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
        <a href="user-profile.php" class="logo d-flex align-items-center">
            <h1 class="d-flex align-items-center">SmartRecruiterX</h1>
        </a>
        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="frontpage.html">Home</a></li>
                <li><a href="logout.html">Logout</a></li>
            </ul>
        </nav><!-- .navbar -->
    </div>
</header><!-- End Header -->

<main id="main">
    <!-- ======= Jumbotron Section ======= -->
    <section id="jumbotron" class="jumbotron">
        <div class="">
            <div class="row">
                <div class="col-lg-12">
                    <div class="header-title">
                        <h1>Interviewer Profile</h1>
                        Welcome, <?php echo htmlspecialchars($first_name . " " . $last_name); ?>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Jumbotron Section -->

    <!-- ======= Profile Section ======= -->
    <section id="profile" class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2><?php echo $first_name . ' ' . $last_name; ?>'s Profile</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="profile-info">
                        <h3>Interviewer Information</h3>
                        <p><strong>Name:</strong> <?php echo $first_name . ' ' . $last_name; ?></p>
                        <p><strong>Email:</strong> <?php echo $user_email; ?></p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="profile-info">
                        <h3></h3>
                        <p><strong>Phone Number:</strong> <?php echo $phone_number; ?></p>
                        <p><strong>LinkedIn Profile:</strong> 
                            <?php
                            if (!empty($linkedin_profile)) {
                                echo '<a href="' . $linkedin_profile . '" target="_blank">' . $linkedin_profile . '</a>';
                            } else {
                                echo 'Not available';
                            }
                            ?>
                        </p>
                        <p><strong>Preferred Communication:</strong> <?php echo $preferred_communication; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Profile Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/purecounter/purecounter.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</body>
</html>
