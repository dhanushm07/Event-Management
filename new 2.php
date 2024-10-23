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

// Function to get the next date
function getNextDate($date) {
    $dateObj = new DateTime($date);
    $dateObj->modify('+1 day');
    return $dateObj->format('Y-m-d');
}

// Function to get the next week's same day
function getNextWeekSameDay($date) {
    $dateObj = new DateTime($date);
    $dateObj->modify('+1 week');
    return $dateObj->format('Y-m-d');
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

// Handle the arrange button click
if (isset($_POST['arrange'])) {
    foreach ($data as $date => &$events) {
        foreach ($events as $event => $count) {
            if ($count > 10) {
                $nextDate = getNextDate($date);
                if (!isset($data[$nextDate])) {
                    $data[$nextDate] = [
                        'listen' => 0,
                        'game' => 0,
                        'meetup' => 0,
                        'food' => 0
                    ];
                }
                
                $data[$nextDate][$event] += $count;
                $events[$event] = 0;
            }
        }
    }

    // Update the database with rearranged data
    $conn->query("DELETE FROM eventhistory"); // Clear existing data

    foreach ($data as $date => $events) {
        foreach ($events as $event => $count) {
            if ($count > 0) {
                $stmt = $conn->prepare("INSERT INTO eventhistory (`Date`, `Event`) VALUES (?, ?)");
                $stmt->bind_param('ss', $date, $event);
                for ($i = 0; $i < $count; $i++) {
                    $stmt->execute();
                }
                $stmt->close();
            }
        }
    }
}

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
        table {
            width: 60%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <h1>Participant Count</h1>
    <form method="post">
        <button type="submit" name="arrange">Arrange</button>
    </form>
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
</body>
</html>

<?php
// Close the connection
$conn->close();
?>
