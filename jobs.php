<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>View Data Analytics</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="page-Data-analytics">

    <!-- ======= Header ======= -->
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="index.html" class="logo d-flex align-items-center">
                <h1 class="d-flex align-items-center">SmartRecruiterX</h1>
            </a>

            <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
            <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a href="frontpage.html">Home</a></li>
                    <li><a href="postad.html">Post Advertisement</a></li>
                    <li><a href="jobs.php">View Data Analytics of Resumes</a></li>
                    <li><a href="candidate-pi.php">Candidate-Profile</a></li>
                    <li><a href="logout.php">Logout</a></li> <!-- Assuming logout.php handles logout -->
                </ul>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->

    <main id="main">

        <!-- ======= Breadcrumbs ======= -->
        <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/darkbackground.jpg');">
            <div class="container position-relative d-flex flex-column align-items-center">

                <h2>View Data Analytics of Resumes</h2>
                <ol>
                    <li><a href="frontpage.html">Home</a></li>
                    <li>View Data Analytics of Resumes</li>
                </ol>

            </div>
        </div><!-- End Breadcrumbs -->

        <!-- ======= Data Analytics Section ======= -->
        <section id="Data-analytics" class="Data-analytics">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>View Data Analytics of Resumes</h2>
                </div>

                <!-- Job Advertisements Table -->
                <?php
                // Mock data for job advertisements
                $jobs = [
                    [
                        'job_title' => 'Junior Software Engineer - Full Stack',
                        'deadline' => '2024-08-01',
                        'description' => 'Work on both front-end and back-end development.',
                        'requirements' => 'Knowledge of JavaScript, HTML, CSS, and back-end languages.'
                    ],
                    [
                        'job_title' => 'Junior Mobile Developer',
                        'deadline' => '2024-08-15',
                        'description' => 'Develop mobile applications for both Android and iOS.',
                        'requirements' => 'Experience with Flutter or React Native.'
                    ]
                ];
                ?>

                <h2>Job Advertisements</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Job Title</th>
                            <th>Deadline</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jobs as $job): ?>
                            <tr onclick="openJobDetails('<?php echo htmlspecialchars($job['job_title']); ?>')">
                                <td><?php echo htmlspecialchars($job['job_title']); ?></td>
                                <td><?php echo htmlspecialchars($job['deadline']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- End Job Advertisements Table -->

            </div>
        </section><!-- End Data Analytics Section -->

    </main><!-- End #main -->

    <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        function openJobDetails(jobTitle) {
            window.location.href = 'job_details.html?job_title=' + encodeURIComponent(jobTitle);
        }
    </script>
</body>

</html>
