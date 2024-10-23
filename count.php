<?php
// Database connection
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

// Query to get the data
$sql = "
    SELECT 
        `Date` AS date, 
        `Event` AS event, 
        COUNT(*) AS count
    FROM 
        `eventhistory`
    GROUP BY 
        `Date`, `Event`
    ORDER BY 
        `Date`, `Event`
";

$result = $conn->query($sql);

$data = [];

// Collect data from the query
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $date = $row['date'];
        $event = $row['event'];
        $count = $row['count'];
        
        if (!isset($data[$date])) {
            $data[$date] = [
                'listen' => 0,
                'game' => 0,
                'meetup' => 0,
                'food' => 0
            ];
        }
        
        $data[$date][$event] = $count;
    }
}

// Get all unique dates
$allDates = array_keys($data);

// HTML Content
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Participant Count</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        h1 {
            color: #444;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
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
    <h1>Participant Count</h1>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Listen</th>
                <th>Game</th>
                <th>Meetup</th>
                <th>Food</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($allDates as $date) {
                $events = $data[$date];
                echo "<tr><td>$date</td><td>{$events['listen']}</td><td>{$events['game']}</td><td>{$events['meetup']}</td><td>{$events['food']}</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <button onclick="adminpanel()">Go back to admin panel</button>
	<br>
	
    <script>
        function adminpanel() {
            window.location.href = 'adminpanel.php';
        }

    </script>
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
