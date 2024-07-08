<?php
// Mock data for job advertisements and detailed data
$jobs = [
    'Junior Software Engineer - Full Stack' => [
        'deadline' => '2024-08-01',
        'description' => 'Work on both front-end and back-end development.',
        'requirements' => 'Knowledge of JavaScript, HTML, CSS, and back-end languages.',
        'number_of_applicants' => 2,
        'interviewer_status' => [
            'Not Interviewed' => 1,
            'Waiting' => 0,
            'Interviewed' => 1
        ],
        'geographical_distribution' => [
            'Colombo' => 1,
            'Gampaha' => 0,
            'Kalutara' => 0,
            'Kandy' => 0,
            'Matale' => 0,
            'Nuwara Eliya' => 0,
            'Galle' => 0,
            'Matara' => 0,
            'Hambantota' => 0,
            'Jaffna' => 0,
            'Kilinochchi' => 0,
            'Mannar' => 0,
            'Vavuniya' => 0,
            'Mullaitivu' => 0,
            'Batticaloa' => 0,
            'Ampara' => 0,
            'Trincomalee' => 0,
            'Kurunegala' => 0,
            'Puttalam' => 0,
            'Anuradhapura' => 0,
            'Polonnaruwa' => 0,
            'Badulla' => 0,
            'Moneragala' => 0,
            'Ratnapura' => 0,
            'Kegalle' => 1
        ],
        'university_distribution' => [
            'University of Colombo' => 1,
            'University of Peradeniya' => 0,
            'University of Sri Jayewardenepura' => 0,
            'University of Kelaniya' => 0,
            'University of Moratuwa' => 1,
            'University of Jaffna' => 0,
            'University of Ruhuna' => 0,
            'Open University of Sri Lanka' => 0,
            'Eastern University, Sri Lanka' => 0,
            'South Eastern University of Sri Lanka' => 0,
            'Rajarata University of Sri Lanka' => 0,
            'Sabaragamuwa University of Sri Lanka' => 0,
            'Wayamba University of Sri Lanka' => 0,
            'University of the Visual and Performing Arts' => 0,
            'Uva Wellassa University' => 0,
            'University of Vocational Technology' => 0,
            'National Institute of Education' => 0,
            'Sri Lanka Institute of Information Technology' => 0
        ]
    ]
];

// Assume you have extracted job details and formatted data as needed
$job_title = 'Junior Software Engineer - Full Stack';
$job_data = $jobs[$job_title];

// Convert data to JSON format for JavaScript consumption
$interviewer_status_json = json_encode($job_data['interviewer_status']);
$geo_distribution_json = json_encode($job_data['geographical_distribution']);
$uni_distribution_json = json_encode($job_data['university_distribution']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Details</title>
    <!-- Include Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <!-- Job Details Section -->
    <section id="job-details">
        <h2>Job Details: <?php echo $job_title; ?></h2>
        <p><strong>Deadline:</strong> <?php echo $job_data['deadline']; ?></p>
        <p><strong>Description:</strong> <?php echo $job_data['description']; ?></p>
        <p><strong>Requirements:</strong> <?php echo $job_data['requirements']; ?></p>
        <p><strong>Number of Applicants:</strong> <?php echo $job_data['number_of_applicants']; ?></p>

        <!-- Charts -->
        <h3>Interviewer Status</h3>
        <canvas id="interviewerStatusChart"></canvas>

        <h3>Geographical Distribution</h3>
        <canvas id="geoDistributionChart"></canvas>

        <h3>University Distribution</h3>
        <canvas id="universityDistributionChart"></canvas>
    </section>

    <!-- Script to create Charts -->
    <script>
        // Interviewer Status Chart
        var interviewerStatusData = <?php echo $interviewer_status_json; ?>;
        var interviewerStatusLabels = Object.keys(interviewerStatusData);
        var interviewerStatusValues = Object.values(interviewerStatusData);

        var interviewerStatusChart = new Chart(document.getElementById('interviewerStatusChart'), {
            type: 'bar',
            data: {
                labels: interviewerStatusLabels,
                datasets: [{
                    label: 'Number of Applicants',
                    data: interviewerStatusValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Geographical Distribution Chart
        var geoDistributionData = <?php echo $geo_distribution_json; ?>;
        var geoDistributionLabels = Object.keys(geoDistributionData);
        var geoDistributionValues = Object.values(geoDistributionData);

        var geoDistributionChart = new Chart(document.getElementById('geoDistributionChart'), {
            type: 'pie',
            data: {
                labels: geoDistributionLabels,
                datasets: [{
                    label: 'Geographical Distribution',
                    data: geoDistributionValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    hoverOffset: 4
                }]
            }
        });

        // University Distribution Chart
        var uniDistributionData = <?php echo $uni_distribution_json; ?>;
        var uniDistributionLabels = Object.keys(uniDistributionData);
        var uniDistributionValues = Object.values(uniDistributionData);

        var uniDistributionChart = new Chart(document.getElementById('universityDistributionChart'), {
            type: 'doughnut',
            data: {
                labels: uniDistributionLabels,
                datasets: [{
                    label: 'University Distribution',
                    data: uniDistributionValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)'
                    ],
                    hoverOffset: 4
                }]
            }
        });
    </script>
</body>

</html>
