<?php
include 'dbuser.php'; // Include the database connection script
$conn = connectDB(); // Call the function to get database connection

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    // Query to fetch candidate details with additional condition on password
    $candidate_query = "SELECT u.First_Name, u.Last_Name, u.Email, c.Mobile_No, c.NIC_No, c.Civil_Status, c.DOB, c.District, c.Work_Preference, c.Availability, c.Reason, c.Job_Position
                        FROM user u
                        LEFT JOIN candidate c ON u.Email = c.C_Email
                        WHERE u.Role = 'Candidate' AND u.Email = ? AND (c.C_Password IS NULL OR c.C_Password = '')";
    $stmt = $conn->prepare($candidate_query);
    if ($stmt === false) {
        // Handle query preparation error
        echo json_encode(array('error' => 'Query preparation error: ' . $conn->error));
        exit();
    }
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result === false) {
        // Handle query execution error
        echo json_encode(array('error' => 'Query execution error: ' . $stmt->error));
        exit();
    }
    $candidate_details = $result->fetch_assoc();
    if ($candidate_details === null) {
        // No candidate found with the given email
        echo json_encode(array('error' => 'Candidate not found'));
    } else {
        // Encode candidate details as JSON and output
        echo json_encode($candidate_details);
    }
    $stmt->close();
} else {
    // Handle case where email parameter is not provided
    echo json_encode(array('error' => 'Email parameter is missing'));
}

$conn->close();
?>
