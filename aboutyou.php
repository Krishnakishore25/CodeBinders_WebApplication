<?php
// Validate and process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection file
    include 'db.php';

    

    // Retrieve form data
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $linkedin = $_POST['linkedin'];
    $communication = $_POST['communication'];

    // Perform validation (you can add more detailed validation here)
    if (empty($email)) {
        echo "Email is required.";
    } else {
        // Check if the email already exists in the database
        $stmt = $conn->prepare("SELECT * FROM interviewer WHERE I_Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        // Start a transaction
        $conn->begin_transaction();

        try {
            if ($result->num_rows > 0) {
                // Email exists, perform an UPDATE
                $stmt_update = $conn->prepare("UPDATE interviewer SET phone_number = ?, linkedin_profile = ?, preferred_communication = ? WHERE I_Email = ?");
                $stmt_update->bind_param("ssss", $phone, $linkedin, $communication, $email);
                $stmt_update->execute();
                $stmt_update->close();
                $message = "Data updated successfully!";
            } else {
                // Email does not exist, perform an INSERT
                $stmt_insert = $conn->prepare("INSERT INTO interviewer (I_Email, phone_number, linkedin_profile, preferred_communication) VALUES (?, ?, ?, ?)");
                $stmt_insert->bind_param("ssss", $email, $phone, $linkedin, $communication);
                $stmt_insert->execute();
                $stmt_insert->close();
                $message = "Data inserted successfully!";
            }

            // Commit the transaction
            $conn->commit();
        } catch (Exception $e) {
            // Rollback the transaction if something went wrong
            $conn->rollback();
            $message = "Error: " . $e->getMessage();
        }
    }

    // Close the database connection
    $conn->close();
    
    // Redirect to frontpage.html after a short delay
    echo "<script>
            setTimeout(function() {
                alert('$message');
                window.location.href = 'frontpage.html';
            }, 500);
          </script>";
}
?>
