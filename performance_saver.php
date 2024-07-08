
<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
</html>
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

        $id = isset($_POST['id']) ? $_POST['id'] : '';
        $q1Answer = isset($_POST['q1']) ? $_POST['q1'] : '';
        $q2Answer = isset($_POST['q2']) ? $_POST['q2'] : '';
        $q3Answer = isset($_POST['q3']) ? $_POST['q3'] : '';
        $q4Answer = isset($_POST['q4']) ? $_POST['q4'] : '';
        $q5Answer = isset($_POST['q5']) ? $_POST['q5'] : '';
        $q6Answer = isset($_POST['q6']) ? $_POST['q6'] : '';
        //$category = $_POST['category']; 
        $result = 0;

        // Update counts for "satisfactory" answers in the database
        if ($q1Answer == 'p') {
            $result = $result + 3;
        }
        elseif($q1Answer == 'a'){
            $result = $result + 2;
        }
        elseif($q1Answer == 'i'){
            $result++;
        }


        if ($q2Answer == 'p') {
            $result = $result + 3;
        }
        elseif($q2Answer == 'a'){
            $result = $result + 2;
        }
        elseif($q2Answer == 'i'){
            $result++;
        }
        
        if ($q3Answer == 'p') {
            $result = $result + 3;
        }
        elseif($q3Answer == 'a'){
            $result = $result + 2;
        }
        elseif($q3Answer == 'i'){
            $result++;
        }

        if ($q4Answer == 'p') {
            $result = $result + 3;
        }
        elseif($q4Answer == 'a'){
            $result = $result + 2;
        }
        elseif($q4Answer == 'i'){
            $result++;
        }

        if ($q5Answer == 'p') {
            $result = $result + 3;
        }
        elseif($q5Answer == 'a'){
            $result = $result + 2;
        }
        elseif($q5Answer == 'i'){
            $result++;
        }
        
        if ($q6Answer == 'p') {
            $result = $result + 3;
        }
        elseif($q6Answer == 'a'){
            $result = $result + 2;
        }
        elseif($q6Answer == 'i'){
            $result++;
        }
        
        
        $sql = "UPDATE resumes SET performance = $result WHERE Resume_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();
        
        if($stmt){
            ?>
            <script>

            Swal.fire({
            title: "Success",
            text: "Performance Saved!",
            icon: "success"
            }).then(() => {
                window.history.go(-1); 
            });


            </script>

            <?php
        }
      

    }
?>
