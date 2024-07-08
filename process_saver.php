<?php 
session_start();
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

        if (isset($_GET['adId'])) {
            $title = $_GET['adId'];}

        if (isset($_SESSION['email'])) {
            $I_Email = $_SESSION['email'];}
        date_default_timezone_set('Asia/Colombo');
        $date=date('Y-m-d');
        $time= date('H:i:s');


$sql = "INSERT INTO process (I_Email, Process_Date, Process_Time, Job_Title )
        VALUES (?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare statement failed: " . $conn->error);
}

// Bind parameters and execute the statement
$stmt->bind_param("ssss", $I_Email, $date, $time, $title);

if ($stmt->execute()) {
    echo "Record inserted successfully.";
    echo $date;
    echo $time;
    echo $title;
} else {
    echo "Error inserting record: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
      

    }
?>
