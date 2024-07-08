
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


  <!-- Template Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">


  <style>
    .main-container {
      background:linear-gradient(90deg, rgba(90,52,113,1) 33%, rgba(16,47,140,1) 83%);
      color: white; /* White text color */
      padding: 20px;
      border-radius: 5px;
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
      border: 2px solid #6a0dad; /* Purple border */
      border-radius: 12px; /* Rounded corners */
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .left-container {
      width: 60%;
    }

    .right-container {
      width: 38%;
    }

    .right-container .card {
      background-color:white; /* Dark background for contrast */
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
      margin-bottom: 0.50rem;
      font-style:italic;
      color: #6a0dad;
    }

    .return-btn {
      margin-top: 20px;
    }
    h1{
      font-size:60px;

    }
    .card-text{
      font-size:35px;
    }
    .zoom {
    padding: 50px;
    background-color: green;
    transition: transform .2s; /* Animation */
    width: 200px;
    height: 200px;
    margin: 0 auto;
    }

  .zoom:hover {
    transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
  }
  input[type="text"] {
  width: 50px; 
  }

  .form-inline {
    display: flex;
    align-items: center;
  }
  .form-inline label {
    margin-right: 10px; 
  }
  .radio-container {
  display: flex;
  gap: 20px; 
  margin-bottom:10px;
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
    p{
      color:#6a0dad;
      margin-bottom:2px;
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
          <li><a href="questions.html" class="active">View Recommended Questions</a></li>
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

        <h2>View Recommended Questions</h2>
        <ol>
          <li><a href="index.html">Home</a></li>
          <li>View Recommended Questions</li>
        </ol>

      </div>
    </div><!-- End Breadcrumbs -->

    <!-- ======= View Recommended Questions Section ======= -->
    <section id="view-questions" class="view-questions">
      <div class="container" data-aos="fade-up">
        <div class="main-container">
          <div class="left-container" >
            <!-- ======= for fullname at top ======= -->
            <h1><i class="bi bi-person-bounding-box"></i>
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

                      else{

                          // Get the ID from the form
                          //$id = isset($_POST['id']) ? $_POST['id'] : '';
                          if (isset($_GET['id'])) {
                             $id = $_GET['id'];}

                          // Prepare the SQL statement
                          $stmt = $conn->prepare("SELECT user.First_Name, user.Last_Name 
                          FROM user
                                INNER JOIN resumes ON user.Email = resumes.C_Email
                          WHERE Resume_ID = ?");
                          

                          $stmt->bind_param("s", $id);

                          // Execute the query
                          $stmt->execute();

                          // Bind the result
                          $stmt->bind_result($f_name, $l_name);
                          $stmt->fetch();

                          echo $f_name.' '.$l_name;
                          // Close the statement
                          $stmt->close();
                      }
                    ?>

            </h1>

            <div class="card">
            <div class="card-body">
            <h4 class="card-title"><i class="bi bi-list-ul"></i> Recommended Questions </h4>
            <p class="card-text">
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

                else{

                    // Get the ID from the form
                    if (isset($_GET['id'])) {
                             $id = $_GET['id'];}

                    // Prepare the SQL statement
                    $stmt = $conn->prepare("SELECT Questions FROM resumes WHERE Resume_ID = ?");

                    $stmt->bind_param("s", $id);

                    // Execute the query
                    $stmt->execute();

                    // Bind the result
                    $stmt->bind_result($doc);
                    $stmt->fetch();

                    // Close the statement
                    $stmt->close();

                    $blob = base64_encode($doc);
                    
                    // Generate the HTML with the object tag
                    echo "<!DOCTYPE html>";
                    echo "<html lang='en'>";
                    echo "<head><meta charset='UTF-8'><title>PDF Display</title></head>";
                    echo "<body>";
                    echo "<object data='data:application/pdf;base64,$blob' type='application/pdf' style='height:700px;width:100%'></object>";
                    echo "</body>";
                    echo "</html>";
                
                        

                    // Close  the connection
                    
                    $conn->close();
                }
              ?>
              </p>
              
              
              
          </div>
          </div>
           <div class="card" style="margin-top:20px;">
            <div class="card-body">
            <h4 class="card-title"><i class="bi bi-chat-left-quote-fill"></i> Performance Review </h4>
            <p class="form-group">
              <form action="comments_saver.php" method="post">
                <div class="form-inline">
                <label for="id" >Resume ID:</label>
                <input type="text" class="form-control form-control-sm"name="id" id="id" value="<?php $id = isset($_GET['id']) ? $_GET['id'] : ''; echo $id?> ">
                </div>

                <br>
                <label for="comments" class="form-label">Comments:</label> <br>
                <textarea rows="3" cols="50" name="comments" id="comments" class="form-control">No comments</textarea>
                <br>
                <button class="btn btn-modern" type="submit">Finish Interview</button>
              </form>
              </p>
          </div>     
        </div>
              </div>

              
          

          <div class="right-container">
          <div class="card" style="margin-top :80px;">
              <div class="card-body">
               
                <h5 class="card-title"><i class="bi bi-list-check"></i> Interview Performance Tracker</h5>
                
                <form action="performance_saver.php" method="post" id="score">
                
                  <div class="form-inline">
                  <label for="id" >Resume ID:</label>
                  <input type="text"  class="form-control form-control-sm"  name="id" id="id" value="<?php $id = isset($_GET['id']) ? $_GET['id'] : ''; echo $id?> ">
                  </div>

                 <br>
                 
                  <!-- Question 1 -->
                  <p>Question 1:</p>
                  <div class="radio-container ">
                  <label><input type="radio" name="q1" value="p"> Proficient</label>
                  <label><input type="radio" name="q1" value="a"> Adequate</label>
                  <label><input type="radio" name="q1" value="i"> Inadequate</label>
                  <label><input type="radio" name="q1" value="e"> Evasive</label>
                  </div>
                  
                  <p>Question 2:</p> 
                  <div class="radio-container">
                  <label><input type="radio" name="q2" value="p"> Proficient</label>
                  <label><input type="radio" name="q2" value="a"> Adequate</label>
                  <label><input type="radio" name="q2" value="i"> Inadequate</label>
                  <label><input type="radio" name="q2" value="e"> Evasive</label>
                  </div>
                 
                  <p>Question 3:</p>
                  <div class="radio-container">
                  <label><input type="radio" name="q3" value="p"> Proficient</label>
                  <label><input type="radio" name="q3" value="a"> Adequate</label>
                  <label><input type="radio" name="q3" value="i"> Inadequate</label>
                  <label><input type="radio" name="q3" value="e"> Evasive</label>
                  </div>

                  <p>Question 4:</p> 
                  <div class="radio-container">
                  <label><input type="radio" name="q4" value="p"> Proficient</label>
                  <label><input type="radio" name="q4" value="a"> Adequate</label>
                  <label><input type="radio" name="q4" value="i"> Inadequate</label>
                  <label><input type="radio" name="q4" value="e"> Evasive</label>
                  </div>

                  <p>Question 5:</p>
                  <div class="radio-container">
                  <label><input type="radio" name="q5" value="p"> Proficient</label>
                  <label><input type="radio" name="q5" value="a"> Adequate</label>
                  <label><input type="radio" name="q5" value="i"> Inadequate</label>
                  <label><input type="radio" name="q5" value="e"> Evasive</label>
                  </div>

                  <p>Question 6:</p>
                  <div class="radio-container">
                  <label><input type="radio" name="q6" value="p"> Proficient</label>
                  <label><input type="radio" name="q6" value="a"> Adequate</label>
                  <label><input type="radio" name="q6" value="i"> Inadequate</label>
                  <label><input type="radio" name="q6" value="e"> Evasive</label>
                  </div>
                  
                  <br>

                  <button class="btn btn-modern" type="submit" >Save Performance</button>
                  <br>

                 
                </form>
              
              </div>
            </div>


            <div class="card" >
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-person"></i> Ego Analysis Score</h5>
                <p class="card-text" style="color:black;">
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

                      else{

                          // Get the ID from the form
                          if (isset($_GET['id'])) {
                             $id = $_GET['id'];}

                          // Prepare the SQL statement
                          $stmt = $conn->prepare("SELECT Ego_Score FROM resumes WHERE Resume_ID = ?");

                          $stmt->bind_param("s", $id);

                          // Execute the query
                          $stmt->execute();

                          // Bind the result
                          $stmt->bind_result($score);
                          $stmt->fetch();

                          echo $score;
                          // Close the statement
                          $stmt->close();
                      }
                    ?>
              </p> 
              </div>
       
            </div>

            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-person-lines-fill"></i> Interpersonal Skills Analysis Score</h5>
                <p class="card-text" style="color:black;">
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

                    else{

                        // Get the ID from the form
                        if (isset($_GET['id'])) {
                             $id = $_GET['id'];}

                        // Prepare the SQL statement
                        $stmt = $conn->prepare("SELECT Ip_Score FROM resumes WHERE Resume_ID = ?");

                        $stmt->bind_param("s", $id);

                        // Execute the query
                        $stmt->execute();

                        // Bind the result
                        $stmt->bind_result($score);
                        $stmt->fetch();

                        echo $score;
                        // Close the statement
                        $stmt->close();
                    }
                  ?>
                </p> 
              </div>
            </div>

            
            
            <div class="card">
              <div class="card-body">
                <h5 class="card-title"><i class="bi bi-file-earmark"></i> Resume </h5>
                
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

                    else{

                        // Get the ID from the form
                        if (isset($_GET['id'])) {
                             $id = $_GET['id'];}


                        // Query the PDF blob (replace table and column names)
                        $sql = "SELECT R_Link FROM resumes WHERE Resume_ID = ?"; 
                        $stmt=$conn->prepare($sql);
                        $stmt->bind_param("s", $id);

                        $stmt->execute();

                        $stmt->bind_result($link);
                        $stmt->fetch();

                        // Close the statement
                        $stmt->close();
                        $resume = base64_encode($link);
                        
                        //echo $link;
                        echo "<!DOCTYPE html>";
                        echo "<html lang='en'>";
                        echo "<head><meta charset='UTF-8'><title>PDF Display</title></head>";
                        echo "<body>";
                        //echo "<p><a href= $resume >View Resume</a></p> ";
                        echo "<object data='data:application/pdf;base64,$resume' type='application/pdf' style='height:400px;width:100%'></object>";
                        echo "</body>";
                        echo "</html>";

                    }
                  ?>
                
              </div>
              
            </div>
           
        
      </div>
      
          </div>
           <div class="text-center return-btn" >
          <a href="#" onclick="javascript:history.back();" class="btn btn-modern">Return</a>
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
  </script>
 
  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  

</body>

</html>


