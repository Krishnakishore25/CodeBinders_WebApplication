<?php
session_start();

// Check if user is logged in based on session email
if (isset($_SESSION['email']) && !empty($_SESSION['email'])) {
    // User is logged in, respond with JSON indicating logged in status
    $response = array('logged_in' => true);
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; // Exit to prevent further execution
}

// If user is not logged in, redirect to index.php
header('Location: index.php');
exit;
?>
