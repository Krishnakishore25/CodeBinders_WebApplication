<?php
// Start session
session_start();

// Check if user is not logged in, redirect to login page
if (!isset($_SESSION['email'])) {
    header('Location: login.php'); // Replace with your login page URL
    exit;
}

// Database connection settings
$host = 'localhost';
$db = 'interviewsupportsystem';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Define the technical skills to be displayed with their respective categories
$technical_skills = [
    "Programming Languages" => ["Java", "Python", "C/C++", "JavaScript", "PHP", "C#", "Ruby", "SQL"],
    "Web Development" => ["HTML/CSS", "JavaScript Frameworks (Angular, React, Vue.js)", "Backend Development (Node.js, Django, Flask)", "Web APIs"],
    "Database Management" => ["SQL Databases (MySQL, PostgreSQL, Oracle)", "NoSQL Databases (MongoDB, Firebase)", "Database Design and Management"],
    "Software Development" => ["Object-Oriented Programming (OOP)", "Agile and Scrum Methodologies", "Version Control Systems (Git)", "Integrated Development Environments (IDEs) like IntelliJ IDEA, Visual Studio Code"],
    "Mobile App Development" => ["Android Development (Java/Kotlin)", "iOS Development (Swift)", "Cross-Platform Development (Flutter, React Native)"],
    "Data Science and Analytics" => ["Data Analysis and Visualization (Pandas, NumPy, Matplotlib)", "Machine Learning (Scikit-learn, TensorFlow, Keras)", "Statistical Analysis"],
    "Networking and Security" => ["Network Configuration and Management", "Cybersecurity Fundamentals", "Network Security Protocols"],
    "Cloud Computing" => ["AWS", "Azure", "Google Cloud Platform (GCP)", "Cloud Infrastructure Management", "Containerization (Docker, Kubernetes)"],
    "DevOps" => ["Continuous Integration/Continuous Deployment (CI/CD)", "Automation Tools (Jenkins, Ansible)", "Infrastructure as Code (Terraform)"],
    "Software Testing" => ["Automated Testing Tools (Selenium, JUnit)", "Manual Testing Techniques", "Test-Driven Development (TDD)"],
];

// SQL query to fetch skills from resumes table
$query_skills = "SELECT skills FROM resumes";
$stmt_skills = $pdo->query($query_skills);

$skillsData = [];

// Initialize the skillsData array with categories
foreach ($technical_skills as $category => $skills) {
    foreach ($skills as $skill) {
        $skillsData[$skill] = [
            'category' => $category,
            'count' => 0,
        ];
    }
}

// Process each row from the database for skills count
while ($row = $stmt_skills->fetch()) {
    $skills = explode(',', $row['skills']); // Assuming skills are stored as a comma-separated string

    foreach ($skills as $skill) {
        $skill = trim($skill);
        if (isset($skillsData[$skill])) {
            $skillsData[$skill]['count']++;
        }
    }
}

// SQL query to fetch top 5 candidates with maximum scores
$query_top_candidates = "SELECT r.Resume_ID, r.similarity_score, r.Ip_Score AS iq_score, r.Ego_Score, r.C_Email, u.First_Name, u.Last_Name
                         FROM resumes r
                         INNER JOIN user u ON r.C_Email = u.Email
                         ORDER BY r.similarity_score DESC, r.Ip_Score DESC, r.Ego_Score DESC
                         LIMIT 5";

$stmt_top_candidates = $pdo->query($query_top_candidates);
$candidates = $stmt_top_candidates->fetchAll();

// Prepare data for spider graph
$candidateNames = [];
$similarityScores = [];
$iqScores = [];
$egoScores = [];

foreach ($candidates as $candidate) {
    $candidateNames[] = $candidate['First_Name'] . ' ' . $candidate['Last_Name'];
    $similarityScores[] = $candidate['similarity_score'];
    $iqScores[] = $candidate['iq_score'];
    $egoScores[] = $candidate['Ego_Score'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Special Analytics</title>
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

<body class="page-special-analytics">

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
                    
                   
                    <li><a href="View_Data_Analysis_Of_Resumes.html">View Data Analytics of Resumes</a></li>
                    
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

                <h2>Special Analytics of Resumes</h2>
                <ol>
                    <li><a href="frontpage.html">Home</a></li>
                    <li>Special Analytics of Resumes</li>
                </ol>

            </div>
        </div><!-- End Breadcrumbs -->

        <!-- ======= Special Analytics Section ======= -->
        <section id="special-analytics" class="special-analytics">
            <div class="container" data-aos="fade-up">
                <div class="section-header">
                    <h2>Special Analytics of Resumes</h2>
                </div>

                <?php if (!empty($skillsData)) : ?>
                    <h3>Candidates Count by Technical Skill</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Technical Skill</th>
                                <th>Number of Candidates</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($technical_skills as $category => $skills) : ?>
                                <?php $firstSkill = true; ?>
                                <?php foreach ($skills as $skill) : ?>
                                    <tr>
                                        <?php if ($firstSkill) : ?>
                                            <td rowspan="<?php echo count($skills); ?>"><?php echo htmlspecialchars($category); ?></td>
                                            <?php $firstSkill = false; ?>
                                        <?php endif; ?>
                                        <td><?php echo htmlspecialchars($skill); ?></td>
                                        <td><?php echo $skillsData[$skill]['count']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else : ?>
                    <p>No results found</p>
                <?php endif; ?>

                <!-- Spider Graph Section -->
                <h3>Top 5 Candidates according to Scores</h3>
                <canvas id="spiderChart" width="400" height="400"></canvas>

                <div class="text-center mt-4">
                    <a href="View_Data_Analysis_Of_Resumes.html" class="btn btn-secondary">Back</a>
                    <a href="frontpage.html" class="btn btn-secondary">Return</a>
                </div>

            </div>
        </section><!-- End Special Analytics Section -->

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

    <!-- Script for Spider Graph -->
    <script>
        var ctx = document.getElementById('spiderChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Similarity Score', 'IQ Score', 'Ego Score'],
                datasets: [
                    <?php for ($i = 0; $i < count($candidateNames); $i++) : ?>
                        {
                            label: '<?php echo $candidateNames[$i]; ?>',
                            data: [<?php echo $similarityScores[$i]; ?>, <?php echo $iqScores[$i]; ?>, <?php echo $egoScores[$i]; ?>],
                            borderColor: 'rgba(<?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, 0.6)',
                            backgroundColor: 'rgba(<?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, <?php echo rand(0, 255); ?>, 0.2)',
                            borderWidth: 2
                        },
                    <?php endfor; ?>
                ]
            },
            options: {
                scales: {
                    r: {
                        angleLines: {
                            display: true
                        },
                        suggestedMin: 0,
                        suggestedMax: 100
                    }
                }
            }
        });
    </script>

</body>

</html>
