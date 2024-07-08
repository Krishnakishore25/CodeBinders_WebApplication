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
        $comments = isset($_POST['comments']) ? $_POST['comments'] : '';
        
       

        $sql = "UPDATE resumes SET comments = '$comments', i_status = 'Interviewed' WHERE Resume_ID = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $id);
        $stmt->execute();

        if($stmt){
            ?>
            <script>
              
            Swal.fire({
            title: "Interview Completed",
            text: "Comments Saved!",
            icon: "success"
            }).then(() => {
                window.history.go(-2); // Reload the page
            });


            </script>
            <?php
        }

    }
?>