<?php
include 'db.php';

$sql = "SELECT A_ID, Job_Title, Deadline FROM advertisement";
$result = $conn->query($sql);

$advertisements = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $advertisements[] = $row;
    }
    echo json_encode(['success' => true, 'advertisements' => $advertisements]);
} else {
    echo json_encode(['success' => false, 'error' => 'No advertisements found']);
}

$conn->close();
?>
