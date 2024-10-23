<?php
// index.php

// Function to fetch aggregated data from the database
function fetchData() {
    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "eventmanagement";

    // Create connection
    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to aggregate event counts
    $sql = "SELECT `Date`, (`listen` + `meetup` + `game` + `food`) AS `total_events` FROM `event_count` ORDER BY `Date`";
    $result = $conn->query($sql);

    $data = array();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    $conn->close();

    return $data;
}

if (isset($_GET['action']) && $_GET['action'] === 'fetch') {
    // Return data as JSON if requested
    header('Content-Type: application/json');
    echo json_encode(fetchData());
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Counts Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        canvas {
            max-width: 80%;
            height: auto;
        }
		 button {
            padding: 10px 20px;
            font-size: 16px;
            color: white;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Total Events Over Time</h1>
    <canvas id="eventChart"></canvas>

    <script>
        async function fetchData() {
            const response = await fetch('?action=fetch');
            const data = await response.json();
            return data;
        }

        function renderChart(data) {
            const ctx = document.getElementById('eventChart').getContext('2d');

            const labels = data.map(item => item.Date);
            const totalEventsData = data.map(item => item.total_events);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Total Events',
                            data: totalEventsData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: false,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Date'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Event Count'
                            }
                        }
                    }
                }
            });
        }

        fetchData().then(data => {
            renderChart(data);
        }).catch(error => {
            console.error('Error fetching data:', error);
        });
		function adminpanel() {
            window.location.href = 'adminpanel.php';
        }
    </script>
    <br><br><button onclick="adminpanel()">Go back to admin panel</button>
	
</body>
</html>
