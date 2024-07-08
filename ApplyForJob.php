<?php
header('Content-Type: application/json');

// Include the database connection file
include 'db.php';

$response = array("status" => "", "message" => "");

$action = isset($_GET['action']) ? $_GET['action'] : '';


if ($action == 'get_job_titles') {
    // Fetch job titles from the advertisement table
    $query = "SELECT Job_Title FROM advertisement";
    $result = $conn->query($query);

    $jobTitles = array();
    while ($row = $result->fetch_assoc()) {
        $jobTitles[] = $row;
    }

    // Return the job titles as JSON
    echo json_encode($jobTitles);
    $conn->close();
    exit;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $R_ID = $_POST['randomID']; 
    $C_Email = $_POST['email'];
    $Mobile_No = $_POST['phone'];
    $NIC_No = $_POST['nic'];
    $Civil_Status = $_POST['civilStatus'];
    $DOB = $_POST['dob'];
    $District = $_POST['district'];
    $Work_Preference = $_POST['workPreference'];
    $Availability = $_POST['workDuration'];
    $Reason = $_POST['reasonForApplying'];
    $Job_Position = $_POST['applyingPosition'];

    // Handle the file upload
    if (isset($_FILES['resume']) && $_FILES['resume']['error'] == 0) {
        // Ensure the uploads directory exists
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $fileType = mime_content_type($_FILES['resume']['tmp_name']);
        if ($fileType == "application/pdf") {
            $Resume_Link = $target_dir . basename($_FILES['resume']['name']);
            if (!move_uploaded_file($_FILES['resume']['tmp_name'], $Resume_Link)) {
                $response["status"] = "error";
                $response["message"] = "Failed to upload resume.";
                echo json_encode($response);
                exit;
            }
        } else {
            $response["status"] = "error";
            $response["message"] = "Unsupported file format. Please upload a PDF file.";
            echo json_encode($response);
            exit;
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "Resume file is required.";
        echo json_encode($response);
        exit;
    }

    // Check if email exists in user table
    $stmt = $conn->prepare("SELECT * FROM user WHERE Email = ?");
    $stmt->bind_param("s", $C_Email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $response["status"] = "error";
        $response["message"] = "Email does not exist in the User table.";
        echo json_encode($response);
        exit;
    }
    $stmt->close();

    // Start a transaction
    //$conn->begin_transaction();

    //try {
        // Insert into resumes table
        $stmt = $conn->prepare("INSERT INTO resumes (Resume_ID, C_Email, Job_Title, R_Link) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $R_ID, $C_Email, $Job_Position, $Resume_Link);
        $stmt->execute();
        $stmt->close();

        // Insert into candidate table
        $stmt = $conn->prepare("INSERT INTO candidate (C_Email, Mobile_No, NIC_No, Civil_Status, DOB, District, Work_Preference, Availability, Reason, Job_Position) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssss", $C_Email, $Mobile_No, $NIC_No, $Civil_Status, $DOB, $District, $Work_Preference, $Availability, $Reason, $Job_Position);
        $stmt->execute();
        $stmt->close();


        // Commit the transaction
        $conn->commit();
        $response["status"] = "success";
        $response["message"] = "Application submitted successfully!";
    //} catch (Exception $e) {
        // Rollback the transaction if something went wrong
        //$conn->rollback();
        //$response["status"] = "error";
       // $response["message"] = "Error: " . $e->getMessage();
   // }

    echo json_encode($response);
}

$conn->close();
?>
