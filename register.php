<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



// Include database configuration and PHPMailer
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/send_activation_link.php'; // Include the activation function file

// Ensure the necessary columns exist in the user table
$conn = require __DIR__ . '/db.php';

// Check if 'activation_token' column exists
$result = $conn->query("SHOW COLUMNS FROM user LIKE 'activation_token'");
if ($result->num_rows == 0) {
    // Column doesn't exist, add it
    $conn->query("ALTER TABLE user ADD COLUMN activation_token VARCHAR(32) AFTER password");
}

// Check if 'status' column exists
$result = $conn->query("SHOW COLUMNS FROM user LIKE 'status'");
if ($result->num_rows == 0) {
    // Column doesn't exist, add it
    $conn->query("ALTER TABLE user ADD COLUMN status ENUM('inactive', 'active') DEFAULT 'inactive' AFTER activation_token");
}

// Check if 'role' column exists
$result = $conn->query("SHOW COLUMNS FROM user LIKE 'role'");
if ($result->num_rows == 0) {
    // Column doesn't exist, add it
    $conn->query("ALTER TABLE user ADD COLUMN role ENUM('Candidate', 'Interviewer') AFTER Last_Name");
}

$conn->close();

function validate_password($password) {
    // Ensure password has at least 8 characters, including one letter and one symbol
    return preg_match('/^(?=.*[A-Za-z])(?=.*[^A-Za-z0-9])(?=.*\d).{8,}$/', $password);
}

$response = array("success" => false, "message" => "");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Form Required Field Validation
    foreach ($_POST as $key => $value) {
        if (empty(trim($value))) {
            $response["message"] = ucwords($key) . " field is required";
            echo json_encode($response);
            exit;
        }
    }

    // Password Matching Validation
    if ($_POST['password'] != $_POST['confirmPassword']) {
        $response["message"] = 'Passwords should be the same';
        echo json_encode($response);
        exit;
    }

    // Password Strength Validation
    if (!validate_password($_POST['password'])) {
        $response["message"] = 'Password must be at least 8 characters long, and include at least one letter and one symbol.';
        echo json_encode($response);
        exit;
    }

    // Email Validation
    if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        $response["message"] = "Invalid Email";
        echo json_encode($response);
        exit;
    }

    // Role Validation
    if (!isset($_POST["role"])) {
        $response["message"] = "Role field is required";
        echo json_encode($response);
        exit;
    }

    $conn = require __DIR__ . '/db.php';

    // Check if email is already registered
    $stmt = $conn->prepare("SELECT COUNT(*) FROM user WHERE Email = ?");
    $stmt->bind_param("s", $_POST["email"]);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count == 0) {
        // Generate a random activation token
        $activation_token = bin2hex(random_bytes(16)); 

        // Insert into user table
        $hashedpassword = password_hash($_POST["password"], PASSWORD_DEFAULT); // Hash the password
        $role = $_POST["role"];
        $email = $_POST["email"];
        $firstName = $_POST["firstName"];
        $lastName = $_POST["lastName"];
        $query = "INSERT INTO user (Email, First_Name, Last_Name, Password, activation_token, status, role) VALUES (?, ?, ?, ?, ?, 'inactive', ?)"; // Ensure your user table has a Password column
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssss", $email, $firstName, $lastName, $hashedpassword, $activation_token, $role); // Bind hashed password correctly

        if ($stmt->execute()) {
            // Send activation email
            if (sendActivationLink($_POST["email"], $activation_token)) {
                $response["success"] = true;
                $response["message"] = "You have registered successfully. Please check your email to activate your account.";
                $response["login_link"] = "beforelogin.html"; // Replace with actual login page URL
            } else {
                $response["message"] = "Failed to send activation email. Please contact support.";
            }
        } else {
            $response["message"] = "Problem in registration. Try Again!";
        }

        $stmt->close();
    } else {
        $response["message"] = "User Email is already in use.";
    }

    $conn->close();
}

echo json_encode($response);
?>
