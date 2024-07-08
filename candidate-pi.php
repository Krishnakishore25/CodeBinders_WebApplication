<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

include 'dbuser.php'; // Include the database connection script
$conn = connectDB(); // Call the function to get database connection

// Fetch job positions with count of candidates
$job_positions_query = "SELECT Job_Position, COUNT(*) AS Candidate_Count FROM candidate WHERE Job_Position IS NOT NULL AND Job_Position <> '' GROUP BY Job_Position";
$job_positions_result = $conn->query($job_positions_query);
$job_positions = [];
if ($job_positions_result->num_rows > 0) {
    while ($row = $job_positions_result->fetch_assoc()) {
        // Store job position and count as an array only if count > 0
        if ($row['Candidate_Count'] > 0) {
            $job_positions[$row['Job_Position']] = $row['Candidate_Count'];
        }
    }
}

// Fetch candidates based on selected job position
$candidates = [];
$selected_position = '';
if (isset($_POST['job_position'])) {
    $selected_position = $_POST['job_position'];
    $candidate_query = "SELECT u.First_Name, u.Last_Name, u.Email, c.Mobile_No, c.NIC_No, c.Civil_Status, c.DOB, c.District, c.Work_Preference, c.Availability, c.Reason, c.Job_Position
                       FROM user u
                       LEFT JOIN candidate c ON u.Email = c.C_Email
                       WHERE u.Role = 'Candidate' AND (c.Job_Position = ? AND (c.C_Password IS NULL OR c.C_Password = ''))";
                       
    $stmt = $conn->prepare($candidate_query);
    $stmt->bind_param("s", $selected_position);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $candidates[] = $row;
        }
    }
    $stmt->close();
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>User Profile</title>
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
  
  <style>
        /* General reset */
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

        .hidden {
            display: none;
        }

        .btn-modern {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
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
            width: 100%;
            max-width: 200px;
            margin: 0 auto;
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

        .jumbotron h1 {
            font-size: 2.5rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .jumbotron p {
            font-size: 1.2rem;
            margin-bottom: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }

        h1, h2, h3, h4, h5 {
            font-family: 'Open Sans', sans-serif;
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

        .header-title h1 {
            color: #ffffff;
        }

        /* Profile section styles */
        .profile-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            border: 1px solid #6a0dad;
        }

        .section-title {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 15px;
            padding-bottom: 10px;
            background: linear-gradient(to right, #6a0dad, #007bff);
            color: transparent;
            -webkit-background-clip: text;
            border-bottom: 2px solid #6a0dad;
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
        }

        .popup {
            display: none;
            position: fixed;
            z-index: 999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding-top: 60px;
        }

        .popup-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 800px;
            border-radius: 10px;
            position: relative;
        }

        .popup-close {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            color: #888;
        }

        .popup-close:hover {
            color: #333;
        }

        .btn-view-more,
        .btn-view-less,
        .btn-return {
            display: block;
            margin: auto;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: 600;
            color: #fff;
            background-color: #6a11cb;
            background-image: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .btn-view-more:hover,
        .btn-view-less:hover,
        .btn-return-less:hover {
            background-color: #2575fc;
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

            .btn-modern {
                padding: 12px 20px;
                font-size: 1rem;
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
        </nav>
    </div>
</header>

<main id="main">
    <!-- ======= Jumbotron Section ======= -->
    <section id="jumbotron" class="jumbotron">
        <div class="container">
            <h1>Welcome to the Candidate Profile</h1>
        </div>
    </section><!-- End Jumbotron Section -->

    <div class="container">
        <div class="filter-section">
            <form method="POST" id="jobPositionForm">
                <div class="profile-section">
                    <div class="section-title">Select Job Position</div>
                    <div class="profile-info">
                    <select class="form-select" name="job_position" id="applyingPosition" style="width: 100%;">
    <option value="">Select Job Position</option>
    <?php foreach ($job_positions as $position => $count): ?>
        <?php if ($count > 0): ?>
            <option value="<?php echo htmlspecialchars($position); ?>">
                <?php echo htmlspecialchars($position . ' (' . $count . ')'); ?>
            </option>
        <?php endif; ?>
    <?php endforeach; ?>
</select>
    
                    <br>
                        <button type="submit" class="btn-modern">Submit</button>
                    </div>
                </div>
            </form>

            <?php if (!empty($candidates)): ?>
                <div class="profile-section">
                    <div class="section-title">Candidates for <?php echo htmlspecialchars($selected_position); ?></div>
                    <ul>
                        <?php foreach ($candidates as $candidate): ?>
                            <li><a href="#" class="candidate-link" data-email="<?php echo htmlspecialchars($candidate['Email']); ?>">
                                    <?php echo htmlspecialchars($candidate['First_Name'] . ' ' . $candidate['Last_Name']); ?>
                                </a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>

        <!-- Popup for Candidate Details -->
        <div id="candidatePopup" class="popup">
    <div class="popup-content">
        <span class="popup-close">&times;</span> <!-- Close button here -->

        <!-- Candidate details will be dynamically inserted here -->

        <div class="profile-section">
            <!-- Additional candidate details -->
        </div>

    </div>
</div>
    </div>
</main>



<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Function to fetch candidate details
        function fetchCandidateDetails(email) {
            fetch('getCandidateDetails.php?email=' + email)
                .then(response => response.json())
                .then(data => {
                    // Construct HTML for displaying initial candidate details
                    const popupContent = document.querySelector('.popup-content');
                    popupContent.innerHTML = `
                        <div class="profile-section">
                            <div class="section-title">Candidate Details</div>
                            <div class="profile-info">
                                <h3>Name:</h3>
                                <p>${data.First_Name} ${data.Last_Name}</p>
                            </div>
                            <div class="profile-info">
                                <h3>Preferred Work:</h3>
                                <p>${data.Work_Preference}</p>
                            </div>
                            <div class="profile-info">
                                <h3>Availability:</h3>
                                <p>${data.Availability}</p>
                            </div>
                            <div class="profile-info">
                                <h3>Reason for Applying:</h3>
                                <p>${data.Reason}</p>
                            </div>
                            <div class="profile-info">
                                <h3>Applied Position:</h3>
                                <p>${data.Job_Position}</p>
                            </div>
                            <div class="additional-details hidden"> <!-- Hidden by default -->
                                <div class="profile-info">
                                    <h3>Email:</h3>
                                    <p>${data.Email}</p>
                                </div>
                                <div class="profile-info">
                                    <h3>Mobile Number:</h3>
                                    <p>${data.Mobile_No}</p>
                                </div>
                                <div class="profile-info">
                                    <h3>NIC Number:</h3>
                                    <p>${data.NIC_No}</p>
                                </div>
                                <div class="profile-info">
                                    <h3>Civil Status:</h3>
                                    <p>${data.Civil_Status}</p>
                                </div>
                                <div class="profile-info">
                                    <h3>Date of Birth:</h3>
                                    <p>${data.DOB}</p>
                                </div>
                                <div class="profile-info">
                                    <h3>District:</h3>
                                    <p>${data.District}</p>
                                </div>
                                <button class="btn btn-view-less">View Less</button>
                            </div>
                            <button class="btn btn-view-more">View More</button>
                            <button class="btn btn-return">Return</button>
                        </div>
                    `;

                    // Show the popup
                    document.getElementById('candidatePopup').style.display = 'block';

                    // Attach event listener to the "View More" button
                    document.querySelector('.btn.btn-view-more').addEventListener('click', function(event) {
                        event.preventDefault();
                        this.style.display = 'none'; // Hide "View More" button
                        document.querySelector('.btn.btn-return').style.display = 'none'; // Hide "Return" button
                        document.querySelector('.additional-details').classList.remove('hidden'); // Show additional details
                        document.querySelector('.btn.btn-view-less').style.display = 'inline-block'; // Show "View Less" button
                    });

                    // Attach event listener to the "Return" button
                    document.querySelector('.btn.btn-return').addEventListener('click', function() {
                        window.location.href = 'candidate-pi.php'; // Replace with your home page URL
                    });

                    // Attach event listener to the "View Less" button
                    document.querySelector('.btn.btn-view-less').addEventListener('click', function(event) {
                        event.preventDefault();
                        document.querySelector('.additional-details').classList.add('hidden'); // Hide additional details
                        document.querySelector('.btn.btn-view-more').style.display = 'inline-block'; // Show "View More" button again
                        document.querySelector('.btn.btn-return').style.display = 'inline-block'; // Show "Return" button again
                    });
                })
                .catch(error => console.error('Error fetching candidate details:', error));
        }

        // Attach click event listeners to all candidate links
        document.querySelectorAll('.candidate-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const email = this.getAttribute('data-email');
                fetchCandidateDetails(email);
            });
        });

        // Close popup functionality
        document.querySelector('.popup-close').addEventListener('click', () => {
            document.getElementById('candidatePopup').style.display = 'none';
            // Clear popup content when closing
            const popupContent = document.querySelector('.popup-content');
            popupContent.innerHTML = '';
        });
    });
</script>

</body>
</html>
