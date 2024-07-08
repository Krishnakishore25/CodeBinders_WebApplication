<?php
// Include the database connection file
include 'db.php';



session_start();

// Check if the user is logged in and retrieve their email from the session
if (isset($_SESSION['email'])) {
    $I_Email = $_SESSION['email'];
} else {
    die(json_encode(['success' => false, 'error' => 'User not logged in']));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $A_ID = uniqid(); // Generate a unique ID for the advertisement
    $A_Description = $conn->real_escape_string($_POST['adContent']);
    $Job_Title = $conn->real_escape_string($_POST['jobTitle']);
    $Deadline = $conn->real_escape_string($_POST['deadline']);

    if (empty($A_Description)) {
        die(json_encode(['success' => false, 'error' => 'Advertisement description cannot be empty']));
    }
    if (empty($Job_Title)) {
        die(json_encode(['success' => false, 'error' => 'Job title cannot be empty']));
    }
    if (empty($Deadline)) {
        die(json_encode(['success' => false, 'error' => 'Deadline cannot be empty']));
    }

    $sql = "INSERT INTO advertisement (A_ID, I_Email, A_Description, A_Link, Deadline, Job_Title, Qualifications) 
            VALUES ('$A_ID', '$I_Email', '$A_Description', '', '$Deadline', '$Job_Title', '')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Database query failed: ' . $conn->error]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method']);
}

$conn->close();
?>
