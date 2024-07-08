<?php
session_start(); // Ensure session is started

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "interviewsupportsystem";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['email'])) {
    $sessionEmail = $_SESSION['email'];

    // Fetch internship titles and count of applicants for each title
    $internshipTitlesQuery = "SELECT Job_Title, COUNT(*) AS Num_Applicants 
                             FROM resumes 
                             WHERE Job_Posted_By = ? 
                             GROUP BY Job_Title";

    // Prepare and execute statement
    $stmtTitles = $conn->prepare($internshipTitlesQuery);
    $stmtTitles->bind_param("s", $sessionEmail);
    $stmtTitles->execute();
    $resultTitles = $stmtTitles->get_result();

    // Check for results
    if ($resultTitles->num_rows > 0) {
        $statusDistribution = array();

        // Fetch status distribution for each job title
        while ($row = $resultTitles->fetch_assoc()) {
            $jobTitle = $row['Job_Title'];
            $numApplicants = $row['Num_Applicants'];

            // Query to get status distribution for each job title
            $statusQuery = "SELECT i_status, COUNT(*) AS Status_Count 
                            FROM resumes 
                            WHERE Job_Title = ? 
                            AND Job_Posted_By = ? 
                            GROUP BY i_status";

            // Prepare and execute statement
            $stmtStatus = $conn->prepare($statusQuery);
            $stmtStatus->bind_param("ss", $jobTitle, $sessionEmail);
            $stmtStatus->execute();
            $resultStatus = $stmtStatus->get_result();

            // Prepare status distribution data
            $statusData = array();
            while ($statusRow = $resultStatus->fetch_assoc()) {
                $status = $statusRow['i_status'];
                $statusCount = $statusRow['Status_Count'];
                $statusData[$status] = $statusCount;
            }

            // Store job title, number of applicants, and status distribution
            $statusDistribution[$jobTitle] = array(
                'Num_Applicants' => $numApplicants,
                'Status_Distribution' => $statusData
            );
        }

        // Log data to file
        // logDataToFile('logfile.txt', $statusDistribution);

        // Fetch district-wise candidate counts for chart
        $districtCounts = fetchDistrictCounts($conn);

        // Fetch education levels, fields of study, and institutions data
        $educationLevels = fetchDataCounts($conn, $sessionEmail, "Education_level");
        $fieldsOfStudy = fetchDataCounts($conn, $sessionEmail, "Fields_of_Study");
        $institutions = fetchDataCounts($conn, $sessionEmail, "Education_institution");

        // Close statement and connection
        $stmtTitles->close();
        $conn->close();

        // Combine data into one array
        $data = array(
            'table' => $statusDistribution,
            'chart' => prepareChartData($districtCounts),
            'educationLevels' => $educationLevels,
            'fieldsOfStudy' => $fieldsOfStudy,
            'institutions' => $institutions
        );

        // Output JSON response
        header('Content-Type: application/json');
        echo json_encode($data);

    } else {
        echo "No internship titles found for the session email.";
    }

} else {
    echo "Session email not set.";
}

// Function to log data to file
function logDataToFile($filename, $data)
{
    $fp = fopen($filename, 'a'); // Open the file in append mode
    $logData = date('Y-m-d H:i:s') . ": " . json_encode($data) . "\n";
    fwrite($fp, $logData); // Write data to file
    fclose($fp); // Close file pointer
}

// Function to fetch district-wise candidate counts
function fetchDistrictCounts($conn)
{
    $allDistricts = array(
        "Colombo",
        "Gampaha",
        "Kalutara",
        "Kandy",
        "Matale",
        "Nuwara Eliya",
        "Galle",
        "Matara",
        "Hambantota",
        "Jaffna",
        "Kilinochchi",
        "Mannar",
        "Vavuniya",
        "Mullaitivu",
        "Batticaloa",
        "Ampara",
        "Trincomalee",
        "Kurunegala",
        "Puttalam",
        "Anuradhapura",
        "Polonnaruwa",
        "Badulla",
        "Moneragala",
        "Ratnapura",
        "Kegalle"
    );

    $districtCounts = array();
    foreach ($allDistricts as $district) {
        $districtCounts[$district] = array();
    }

    // Query to fetch distinct job titles
    $distinctTitlesQuery = "SELECT DISTINCT Job_Title FROM resumes";
    $resultTitles = $conn->query($distinctTitlesQuery);

    if ($resultTitles->num_rows > 0) {
        while ($row = $resultTitles->fetch_assoc()) {
            $jobTitle = $row['Job_Title'];

            // Query to fetch district-wise candidate counts for each job title
            $sqlDistrictCounts = "SELECT location, COUNT(*) AS Candidate_Count 
                                  FROM resumes 
                                  WHERE Job_Title = ? 
                                  AND Job_Posted_By = ? 
                                  GROUP BY location";

            // Prepare and execute statement
            $stmtDistrictCounts = $conn->prepare($sqlDistrictCounts);
            $stmtDistrictCounts->bind_param("ss", $jobTitle, $_SESSION['email']);
            $stmtDistrictCounts->execute();
            $resultDistrictCounts = $stmtDistrictCounts->get_result();

            // Iterate over district-wise candidate counts
            if ($resultDistrictCounts->num_rows > 0) {
                while ($districtRow = $resultDistrictCounts->fetch_assoc()) {
                    $district = $districtRow['location'];
                    $candidateCount = $districtRow['Candidate_Count'];

                    // Store candidate count for the job title in the district
                    $districtCounts[$district][$jobTitle] = $candidateCount;
                }
            }
        }
    }

    logDataToFile('logfile.txt', $districtCounts);

    return $districtCounts;
}

// Function to fetch data counts for education levels, fields of study, and institutions
function fetchDataCounts($conn, $email, $columnName)
{
    $dataCounts = array();

    $sqlQuery = "SELECT $columnName, COUNT(*) AS count 
                 FROM resumes 
                 WHERE Job_Posted_By = ? 
                 GROUP BY $columnName";

    $stmt = $conn->prepare($sqlQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $dataCounts[] = array(
            'label' => $row[$columnName],
            'value' => $row['count']
        );
    }

    $stmt->close();

    return $dataCounts;
}

// Function to prepare chart data
function prepareChartData($districtCounts)
{
    // Get all unique job titles
    $allJobTitles = array();
    foreach ($districtCounts as $district => $counts) {
        foreach ($counts as $jobTitle => $count) {
            if (!in_array($jobTitle, $allJobTitles)) {
                $allJobTitles[] = $jobTitle;
            }
        }
    }

    // Initialize datasets
    $dataSets = array();
    foreach ($allJobTitles as $jobTitle) {
        $dataSets[] = array(
            'label' => $jobTitle,
            'data' => array(),
            'backgroundColor' => "rgba(" . rand(0, 255) . "," . rand(0, 255) . "," . rand(0, 255) . ",0.6)",
            'borderColor' => "rgba(0, 0, 0, 0.1)",
            'borderWidth' => 1
        );
    }

    // Populate datasets with counts for each district
    foreach ($districtCounts as $district => $counts) {
        foreach ($dataSets as &$dataset) {
            $jobTitle = $dataset['label'];
            $dataset['data'][] = isset($counts[$jobTitle]) ? $counts[$jobTitle] : 0;
        }
    }

    // Prepare chart data
    $chartData = array(
        'labels' => array_keys($districtCounts), // District names as labels
        'datasets' => $dataSets
    );

    return $chartData;
}

?>