<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password']; // Changed 'Password' to 'password' to match form field name

        //Database Connection
        $con = new mysqli("localhost", "root", "", "interviewsupportsystem");

        if ($con->connect_error) {
            die("Failed to connect : " . $con->connect_error);
        } else {
            $stmt = $con->prepare("SELECT * FROM user WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt_result = $stmt->get_result();
            if ($stmt_result->num_rows > 0) {
                $data = $stmt_result->fetch_assoc();
                if (password_verify($password, $data['Password'])) {
                    echo "<h2>Login Successful</h2>";
                } else {
                    echo "<h2>Invalid Email or password</h2>";
                }
            } else {
                echo "<h2>Invalid Email or password</h2>";
            }
        }
    } else {
        echo "<h2>Invalid Email or password</h2>";
    }
} else {
    // Form has not been submitted
    echo "<h2>Invalid request</h2>";
}
?>
