<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: eventlogin.php");
    exit();
}

$username = $_SESSION['username'];

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "eventmanagement";

$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Prepare and execute query to get user details
$stmt = $conn->prepare("
    SELECT register.Name, register.Age, register.Gender, register.Phonenum, register.Email
    FROM register
    JOIN login ON register.id = login.Eid
    WHERE login.Username = ?
");
$stmt->bind_param('s', $username);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$alertShown = false; // Flag to track if alert has been shown

if (isset($_POST['register'])) {
    $event = $_POST['Event'];
    $date = $_POST['date'];
    $price = (int)$_POST['price'];

    if (empty($event) || empty($date) || $price <= 0) {
        $alertMessage = "Please select an event, date, and ensure the price is greater than zero.";
    } else {
        // Prepare and execute query to check if the event and date already exist for the user
        $stmt = $conn->prepare("
            SELECT * FROM eventhistory
            WHERE UID = (SELECT id FROM register JOIN login ON register.id = login.Eid WHERE login.Username = ?)
              AND Event = ?
              AND Date = ?
        ");
        $stmt->bind_param('sss', $username, $event, $date);
        $stmt->execute();
        $checkResult = $stmt->get_result();

        if ($checkResult->num_rows > 0) {
            $alertMessage = "Error: You have already registered for this event on this date. Please choose another date or event.";
        } else {
            // Prepare and execute query to check if the date is already filled for this event type
            $stmt = $conn->prepare("
                SELECT $event
                FROM event_count
                WHERE Date = ?
            ");
            $stmt->bind_param('s', $date);
            $stmt->execute();
            $eventCounts = $stmt->get_result()->fetch_assoc();
            $maxCount = 10;

            if ($eventCounts[$event] >= $maxCount) {
                $alertMessage = "Error: The selected date is fully booked for this event. Please choose another date.";
            } else {
                // Prepare and execute query to check if the user is already registered for 4 events on this date
                $stmt = $conn->prepare("
                    SELECT COUNT(*) as EventCount
                    FROM eventhistory
                    WHERE UID = (SELECT id FROM register JOIN login ON register.id = login.Eid WHERE login.Username = ?)
                      AND Date = ?
                ");
                $stmt->bind_param('ss', $username, $date);
                $stmt->execute();
                $userEventsCount = $stmt->get_result()->fetch_assoc()['EventCount'];

                if ($userEventsCount >= 4) {
                    $alertMessage = "Error: You can participate in a maximum of 4 events per day.";
                } else {
                    // Prepare and execute query to insert into eventhistory
                    $stmt = $conn->prepare("
                        INSERT INTO eventhistory (Event, Price, Date, UID)
                        VALUES (?, ?, ?, (SELECT id FROM register JOIN login ON register.id = login.Eid WHERE login.Username = ?))
                    ");
                    $stmt->bind_param('siss', $event, $price, $date, $username);
                    if ($stmt->execute()) {
                        // Prepare and execute query to update event count
                        $stmt = $conn->prepare("
                            INSERT INTO event_count (Date, " . ucfirst($event) . ")
                            VALUES (?, 1)
                            ON DUPLICATE KEY UPDATE " . ucfirst($event) . " = " . ucfirst($event) . " + 1
                        ");
                        $stmt->bind_param('s', $date);
                        $stmt->execute();
                        $alertMessage = "Successfully registered for the new event.";
                    } else {
                        $alertMessage = "Error: " . $conn->error;
                    }
                }
            }
        }
    }

    if (isset($alertMessage) && !$alertShown) {
        echo '<script>alert("' . addslashes($alertMessage) . '");</script>';
        $alertShown = true;
    }
}

// Prepare and execute query to fetch user events
$stmt = $conn->prepare("
    SELECT Event, Price, Date
    FROM eventhistory
    WHERE UID = (SELECT id FROM register JOIN login ON register.id = login.Eid WHERE login.Username = ?)
    ORDER BY Date
");
$stmt->bind_param('s', $username);
$stmt->execute();
$eventsResult = $stmt->get_result();

// Check if user has events
$hasEvents = $eventsResult->num_rows > 0;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 160vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 1200px;
        }

        h1, h4 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-group input[type="submit"] {
            background: #5cb85c;
            color: #fff;
            border: none;
            padding: 15px;
            cursor: pointer;
            font-size: 18px;
            width: auto;
        }

        .form-group input[type="submit"]:hover {
            background: #4cae4c;
        }

        .button-container {
            display: flex;
            justify-content: center;
        }

        button {
            background: #5cb85c;
            color: #fff;
            border: none;
            padding: 15px 25px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 18px;
            margin: 10px 0;
        }

        button:hover {
            background: #4cae4c;
        }

        .event-message {
            text-align: center;
            font-size: 20px;
            margin-bottom: 20px;
        }
    </style>
    <script>
        function pricedisplay() {
            var event = document.forms["newEventForm"]["Event"].value;
            var price = 0;
            switch (event) {
                case "game":
                    price = 75;
                    break;
                case "food":
                    price = 25;
                    break;
                case "meetup":
                    price = 100;
                    break;
                case "listen":
                    price = 50;
                    break;
            }
            document.getElementById("newPriceDisplay").textContent = price > 0 ? "Rs. " + price : "Select an event to see price";
            document.getElementById("newPrice").value = price;
        }

        function validateDate() {
            var inputDate = new Date(document.getElementById("date").value);
            var day = inputDate.getDay(); // getDay() returns 0 for Sunday, 1 for Monday, etc.

            if (isNaN(inputDate.getTime())) {
                return; // if no date is selected, do nothing
            }

            if (day !== 6 && day !== 0) { // 6 = Saturday, 0 = Sunday
                alert("Please select a Saturday or Sunday for the event.");
                document.getElementById("date").value = ""; // Clear the invalid date
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("date").addEventListener("change", validateDate);
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($user['Name']); ?>!</h1>

        <h4>Hi, <?php echo htmlspecialchars($user['Name']); ?>. Thanks for participating in the event.</h4>
        <h4>Just confirm your data:</h4>
        
        <table id="mytable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Event</th>
                    <th>Price</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?php echo htmlspecialchars($user['Name']); ?></td>
                    <td><?php echo htmlspecialchars($user['Age']); ?></td>
                    <td><?php echo htmlspecialchars($user['Gender']); ?></td>
                    <td><?php echo htmlspecialchars($user['Phonenum']); ?></td>
                    <td><?php echo htmlspecialchars($user['Email']); ?></td>
                    <td colspan="3">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Price</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $eventsResult->fetch_assoc()): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($row['Event']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Price']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="event-message">
            <h2><?php echo $hasEvents ? "Register for Another Event" : "Register for an Event"; ?></h2>
        </div>

        <form name="newEventForm" action="homepage.php" method="post">
            <div class="form-group">
                <label for="Event">Select Event:</label>
                <select name="Event" onchange="pricedisplay()">
                    <option value="">Select Event</option>
                    <option value="listen">Listening Event</option>
                    <option value="game">Gaming Event</option>
                    <option value="meetup">Meetup Event</option>
                    <option value="food">Food Event</option>
                </select>
            </div>
            <div class="form-group">
                Price will be: <span id="newPriceDisplay">Select an event to see price</span>
                <input type="hidden" name="price" id="newPrice" value="0">
            </div>
            <div class="form-group">
                <label for="date">Schedule Date for this week (Saturday / Sunday):</label>
                <input type="date" name="date" id="date" min="2024-08-08">
            </div>
            <div class="form-group">
                <input type="submit" name="register" value="Register">
            </div>
        </form>

        <div class="button-container">
            <button onclick="logout()">Logout</button>
        </div>

        <script>
            function logout() {
                window.location.href = "eventlogin.php";
            }
        </script>
    </div>
</body>
</html>
