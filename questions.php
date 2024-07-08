<?php
// Start session to store success message
session_start();
?>
<!DO
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  

  <title>Smart Interview Support Method</title>
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


  <style>
    .selection-box {
      background-color: #007bff; /* Blue background */
      color: white; /* White text color */
      padding: 20px;
      border-radius: 5px;
    }

    .candidate-list a {
      color: white;
      display: block;
      padding: 10px 0;
      text-decoration: none;
    }

    .candidate-list a:hover {
      text-decoration: underline;
    }
    .main-container {
      background:linear-gradient(90deg, rgba(90,52,113,1) 33%, rgba(16,47,140,1) 83%); /* Blue background */
      color: white; /* White text color */
      padding: 20px;
      border-radius: 5px;
      display: flex;
      justify-content: space-between;
       border: 2px solid #6a0dad; /* Purple border */
      border-radius: 12px; /* Rounded corners */
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .left-container {
      width: 1000%;
    }

    .right-container {
      width: 35%;
    }

    .right-container .card {
      background-color: white; /* Dark background for contrast */
      color: black;
      margin-bottom: 10px;
       border: 2px solid #6a0dad; /* Purple border */
      border-radius: 12px; /* Rounded corners */
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    .left-container .card {
      background-color: white; /* Dark background for contrast */
      margin-bottom: 10px;
      border: 2px solid #6a0dad; /* Purple border */
      border-radius: 12px; /* Rounded corners */
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .card-title {
      font-size: 25px;
      font-style:italic;
      margin-bottom: 0.75rem;
      color: #6a0dad;
    }
    h3{
      color: #6a0dad;
      font-style:italic;
    }

    .return-btn {
      margin-top: 20px;
    }
    .btn-modern {
     
      align-items: center;
      justify-content: center;
      padding: 12px 24px;
      font-size: 1.1rem;
      font-weight: 600;
      color: #fff;
      background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
      border: none;
      border-radius: 50px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      transition: all 0.3s ease;
      text-align: center;
      border-color: #6a0dad;

    }
    h2{
      color:red;
      font-style:italic;
    }
  </style>
</head>

<body class="page-View Recommended Questions">

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
          <li><a href="postad.html">Post Advertisement</a></li>
          <li><a href="processcv.html">Process Resume</a></li>
          <li><a href="questions.php" class="active">View Recommended Questions</a></li>
          <li><a href="View_Data_Analysis_Of_Resumes.html">View Data Analytics of Resumes</a></li>
          <li><a href="interviewer-profile.php">Interviewer-Profile</a></li>
          <li><a href="candidate-pi.php">Candidate-Profile</a></li>
          <li><a href="logout.html">Logout</a></li>
        </ul>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <div class="breadcrumbs d-flex align-items-center" style="background-image: url('assets/img/darkbackground.jpg');">
      <div class="container position-relative d-flex flex-column align-items-center">

        <h2>Selected Candidate List</h2>
        <ol>
          <li><a href="index.html">Home</a></li>
          <li>Screened Candidate List</li>
        </ol>

      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= View Recommended Questions Section ======= -->
    <section id="view-questions" class="view-questions">
      <div class="container" data-aos="fade-up">
        <div class="main-container">
          <div class="left-container" >
            
            <div class="card">
                      <div class="card-body">
                        
                        <h3 class="mb-4"><i class="bi bi-person-check"></i> Screened Candidate List</h3>
                        <h4 id="JobTitle"><i class="bi bi-file-earmark-post-fill"></i>
                          <?php $id = isset($_GET['jobTitle']) ? $_GET['jobTitle'] : ''; echo $id?>
                        </h4>
                        <table class="table table-bordered" style="border-color:#6a0dad;" >
                          <thead>
                            <tr>
                              <th scope="col">ResumeID</th>
                              <th scope="col">Name</th>
                              <th scope="col">Similarity</th>
                              <th scope="col">IPS Score</th>
                              <th scope="col">Ego Score</th>
                              <th scope="col">Mode</th>
                              <th scope="col">Availability</th>
                              <th scope="col">Reason</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody id="adTableBody">
                            <?php
                                $host = 'localhost';
                                $dbname = 'interviewsupportsystem';
                                $user = 'root';
                                $pass = '';

                                // Create connection
                                $conn = new mysqli($host, $user, $pass, $dbname);

                                // Check connection
                                if ($conn->connect_error) {
                                  die("Connection failed: " . $conn->connect_error);
                                }

                                if (isset($_GET['jobTitle'])) {
                                  $title = $_GET['jobTitle'];}
                                
                                $stmt = $conn->prepare( "SELECT user.First_Name, user.Last_Name, resumes.Resume_ID, resumes.i_status, resumes.similarity_score, resumes.Ip_Score, resumes.Ego_Score, candidate.Reason,
                                candidate.Work_Preference, candidate.Availability, resumes.Job_Title 
                                FROM user
                                INNER JOIN resumes ON user.Email = resumes.C_Email
                                INNER JOIN candidate ON user.Email = candidate.C_Email
                                WHERE resumes.Job_Title = ?
                                ORDER BY resumes.similarity_score DESC, resumes.Ip_Score DESC, resumes.Ego_Score");

                                $stmt->bind_param("s",$title);
                                $stmt->execute();

                                $result = $stmt->get_result();
                                

                                if ($result->num_rows > 0) {
                                    
                                    // output data of each row
                                   // while($row = $result->fetch_assoc()) {
                                       // echo "<tr><td>".$row["Resume_ID"]."</td><td>".$row["First_Name"]."</td><td>".$row["Last_Name"]."</td><td>".$row["i_status"]."</td></tr>";
                                    foreach ($result as $row) {
                                      echo "<tr>";
                                      echo "<td>" . $row['Resume_ID'] . "</td>";
                                      echo "<td>" . $row['First_Name'] . ' '.$row['Last_Name']."</td>";
                                      echo "<td>" . $row['similarity_score'] . "</td>";
                                      echo "<td>" . $row['Ip_Score'] . "</td>";
                                      echo "<td>" . $row['Ego_Score'] . "</td>";
                                      echo "<td>" . $row['Work_Preference'] . "</td>";
                                      echo "<td>" . $row['Availability'] . "</td>";
                                      echo "<td>" . $row['Reason'] . "</td>";
                                      echo "<td>" . $row['i_status'] . "</td>";
                                      // Other columns...
                                      echo "<td><a href='viewQuestions.php?id=" . $row['Resume_ID'] . "'  >Proceed</a></td>";
                                      echo "</tr>";

                                    }
                                    echo "</table>";
                                    
                                } else {
                                 
                                    
                                    echo "<html>";
                                    echo "<h2>⚠️ No applicants found ❗❗ </h2>";
                                    echo "</html>";
                                    
                                }
                                $conn->close();
                                ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
            
             <div class="text-center return-btn" data-aos="fade-up" data-aos-delay="200" style=" margin-top:40px;margin-bottom:30px;">
          
        
          <a href="overview.php?jobTitle=<?php echo urlencode($title); ?>" class="btn-modern" data-mdb-ripple-init>Final Overview</a>
        </div>
                              
      </div>
            
          </div>
          

         
           <div class="text-center return-btn" data-aos="fade-up" data-aos-delay="200" style=" margin-top:20px;">
          <a href="frontpage.html" class="btn btn-modern" data-mdb-ripple-init>Return</a>
        
          
        </div>             

            
          </div>
          
        </div>

       
      
    </section><!-- End View Recommended Questions Section -->
  </main><!-- End #main -->
                                    <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js">
   function submitJobTitle(jobTitle) {
    // Set the job title value to the input field in the second form
    document.getElementById('jobTitle').value = jobTitle;

    // Submit the second form
    document.getElementById('form2').submit();
  }
</script>


  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

 

</body>

</html>
