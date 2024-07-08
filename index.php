<?php
// Include the database connection file
include 'db.php';

// Fetch job listings
$sql = "SELECT A_ID, A_Description, Job_Title, Deadline, I_Email FROM advertisement";
$result = $conn->query($sql);

$jobs = [];
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $jobs[] = $row;
  }
} else {
  echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>SmartRecruiterX</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Open Sans', sans-serif;
    }

    .job-openings {
      background: rgba(255, 255, 255, 0.7);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .job-openings-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 20px;
    }

    .job-item {
      margin-bottom: 20px;
      padding: 20px;
      background: linear-gradient(135deg, #667eea, #764ba2);
      border-radius: 10px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      color: #fff;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .job-item:hover {
      transform: scale(1.05);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }

    .btn-apply {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease, text-decoration 0.3s ease;
    }

    .btn-apply:hover {
      color: #0056b3;
      text-decoration: underline;
    }

    .btn-get-started {
      display: inline-block;
      margin-top: 10px;
      margin-right: 10px;
      background: #007bff;
      color: #fff;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      transition: background 0.3s ease, transform 0.3s ease;
    }

    .btn-get-started:hover {
      background: #0056b3;
      transform: translateY(-2px);
    }

    .section-title {
      text-align: center;
      margin-bottom: 35px;
      color: #170202;
    }

    .hero h2 {
      color: #fff;
      margin-bottom: 20px;
      font-size: 2.0em;
    }

    .hero p {
      color: #f9f8fa;
      margin-bottom: 20px;
    }

    .scroll-top {
      background: #9900ff;
      color: #fff;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.3s ease;
      position: fixed;
      bottom: 20px;
      right: 20px;
      cursor: pointer;
      opacity: 0;
      visibility: hidden;
      z-index: 9999;
    }

    .scroll-top.show {
      opacity: 1;
      visibility: visible;
    }

    .scroll-top:hover {
      background: #0056b3;
    }

    @keyframes blink {
      0%, 100% {
        opacity: 1;
      }
      50% {
        opacity: 0;
      }
    }

    .blink {
      animation: blink 1s step-start infinite;
    }

    h5 {
      color: #fff;
    }
  </style>
</head>
<body class="page-index">
  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <h1 class="d-flex align-items-center"><br>SmartRecruiterX</h1>
      </a>

      <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
      <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>
    </div>
  </header><!-- End Header -->

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">
    <div class="container">
      <div class="row">
        <div class="col-xl-6 d-flex flex-column justify-content-center">
          <h2 data-aos="fade-up">Welcome to SmartRecruiterX</h2>
          <h5>Register as a candidate to find your dream job <br> Or as an interviewer to streamline recruitment</h5>

          <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
            <a href="registration.html" class="btn-get-started">Register</a>
            <a href="beforelogin.html" class="btn-get-started">Login</a>
          </div>
        </div>

        <!-- Job Openings Section -->
        <div class="col-xl-6">
          <section id="job-openings" class="job-openings">
            <div class="container">
              <div class="section-title blink" data-aos="fade-up">
                <h1>Job Openings</h1>
              </div>
              <div class="row job-openings-grid" id="job-listings">
                <!-- PHP loop to generate job items -->
                <?php foreach ($jobs as $job): ?>
                  <div class="col-md-12" data-aos="fade-up" data-aos-delay="100">
                    <div class="job-item">
                      <h3><?php echo $job['Job_Title']; ?></h3>
                      <p>Deadline: <?php echo date('F j, Y', strtotime($job['Deadline'])); ?></p>
                      <!--a href="login_candidate.html" class="btn-get-started btn-apply">Apply Now</a-->
                      <a href="#" class="btn-get-started view-more" data-job-id="<?php echo $job['A_ID']; ?>" data-description="<?php echo htmlspecialchars($job['A_Description']); ?>" data-email="<?php echo $job['I_Email']; ?>" data-position="<?php echo htmlspecialchars($job['Job_Title']); ?>">View More</a>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          </section><!-- End Job Openings Section -->
        </div>
      </div>
    </div>
  </section><!-- End Hero Section -->

  <main id="main">
    <!-- Job Details Modal -->
    <div class="modal fade" id="jobDetailsModal" tabindex="-1" aria-labelledby="jobDetailsModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="jobDetailsModalLabel">Job Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col-md-12">
                <p id="A_Description"></p>
                <div class="mt-4">
                  <a href="login_candidate.html" class="btn btn-primary">Apply Now</a>
                  <a id="email-cv" class="btn btn-success">Email Your CV</a>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div><!-- End Job Details Modal -->
  </main>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script>
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });

    // Show or hide the scroll-top button
    const scrollTop = document.querySelector('.scroll-top');
    window.addEventListener('scroll', () => {
      if (window.scrollY > 300) {
        scrollTop.classList.add('show');
      } else {
        scrollTop.classList.remove('show');
      }
    });

    // Scroll to top functionality
    scrollTop.addEventListener('click', () => {
      window.scrollTo({
        top: 0,
        behavior: 'smooth'
      });
    });

    // Fetch job details and populate modal
    document.addEventListener('DOMContentLoaded', function() {
      const viewMoreButtons = document.querySelectorAll('.view-more');

      viewMoreButtons.forEach(button => {
        button.addEventListener('click', function(e) {
          e.preventDefault();
          const jobDescription = this.getAttribute('data-description');
          const jobEmail = this.getAttribute('data-email');
          const modalJobDescription = document.getElementById('A_Description');

          if (modalJobDescription && jobDescription) {
            modalJobDescription.innerHTML = `<strong>Description:</strong><br>${jobDescription.trim()}`;
            $('#jobDetailsModal').modal('show');
          } else {
            console.error('Job description not found.');
          }

          const emailCV = document.getElementById('email-cv');

          // Set the mailto link for the "Email Your CV" button
          if (jobEmail) {
            emailCV.href = `mailto:${jobEmail}?subject=Job Application&body=Please find my CV attached.`;
          } else {
            console.error('Job email not found.');
          }
        });
      });
    });
  </script>

</body>
</html>
