<?php
// Start the output buffer
ob_start();
// Database connection and operations now
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "eventmanagement";
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = intval($_GET['id']);
$userQuery = "SELECT * FROM register WHERE Id = ?";
$stmt = mysqli_prepare($conn, $userQuery);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$user = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}

// Retrieve user events
$eventsQuery = "SELECT event, price, date FROM eventhistory WHERE UID = ?";
$stmt = mysqli_prepare($conn, $eventsQuery);
mysqli_stmt_bind_param($stmt, 'i', $id);
mysqli_stmt_execute($stmt);
$eventsResult = mysqli_stmt_get_result($stmt);

$events = [];
while ($row = mysqli_fetch_assoc($eventsResult)) {
    $events[] = $row;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = intval($_POST['age']);
    $gender = $_POST['gender'];
    $phonenum = $_POST['phonenum'];
    $email = $_POST['email'];
    $events = $_POST['events'];
    $prices = $_POST['prices'];
    $dates = $_POST['dates'];

    // Update register table
    $updateQuery = "UPDATE register SET Name = ?, Age = ?, Gender = ?, Phonenum = ?, Email = ? WHERE Id = ?";
    $stmt = mysqli_prepare($conn, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'sisssi', $name, $age, $gender, $phonenum, $email, $id);
    mysqli_stmt_execute($stmt);

    // Delete old events
    $deleteEventsQuery = "DELETE FROM eventhistory WHERE UID = ?";
    $stmt = mysqli_prepare($conn, $deleteEventsQuery);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);

    // Insert new events
    for ($i = 0; $i < count($events); $i++) {
        $event = trim($events[$i]);
        $price = trim($prices[$i]);
        $date = trim($dates[$i]);

        $insertQuery = "INSERT INTO eventhistory (UID, event, price, date) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insertQuery);
        mysqli_stmt_bind_param($stmt, 'isss', $id, $event, $price, $date);
        mysqli_stmt_execute($stmt);
    }

    mysqli_close($conn);
    // Redirect after form submission
    header("Location: view.php");
    exit;
}

// End the output buffer and clean it
ob_end_flush();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 175vh;
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

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
        }

        input[type="text"],
        input[type="number"],
        input[type="email"],
        select,
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 15px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        input[type="number"] {
            -moz-appearance: textfield; /* Remove default number input styles */
        }

        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        button {
            background: #5cb85c;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        button:hover {
            background: #4cae4c;
        }

        .event-row {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background: #f9f9f9;
        }

        .event-row label {
            margin-right: 10px;
        }

        .priceDisplay {
            margin-left: 10px;
            font-weight: bold;
        }

        .remove-btn {
            background: #d9534f;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            margin-left: 10px;
        }

        .remove-btn:hover {
            background: #c9302c;
        }
    </style>
    <script>
        function addEventRow() {
            const container = document.getElementById('eventsContainer');
            const row = document.createElement('div');
            row.className = 'event-row';

            row.innerHTML = `
                <label>Event:</label>
                <select name="events[]" onchange="updatePrice(this)">
                    <option value="">Select Event</option>
                    <option value="listen">Listening Event</option>
                    <option value="game">Gaming Event</option>
                    <option value="meetup">Meetup Event</option>
                    <option value="food">Food Event</option>
                </select>
                <label>Price:</label>
                <input type="number" name="prices[]" min="0" required>
                <label>Date:</label>
                <input type="date" name="dates[]" min="2024-08-08" required>
                <button type="button" class="remove-btn" onclick="removeEventRow(this)">Remove</button>
                <span class="priceDisplay"></span>
            `;
            container.appendChild(row);
        }

        function removeEventRow(button) {
            const row = button.parentNode;
            row.parentNode.removeChild(row);
        }

        function updatePrice(selectElement) {
            const row = selectElement.parentNode;
            const priceDisplay = row.querySelector('.priceDisplay');
            let price = 0;
            switch (selectElement.value) {
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
                default:
                    price = 0;
                    break;
            }
            row.querySelector('input[name="prices[]"]').value = price;
            priceDisplay.textContent = price > 0 ? `Price: Rs. ${price}` : '';
        }

        function validateDates() {
            const dateInputs = document.querySelectorAll('input[name="dates[]"]');
            const eventInputs = document.querySelectorAll('select[name="events[]"]');
            const dateEventMap = {};

            for (let i = 0; i < dateInputs.length; i++) {
                const date = dateInputs[i].value;
                const event = eventInputs[i].value;
                const day = new Date(date).getDay();

                if (day !== 0 && day !== 6) { // Not Saturday or Sunday
                    alert("Dates must be Saturdays or Sundays.");
                    return false;
                }

                if (!dateEventMap[date]) {
                    dateEventMap[date] = new Set();
                }

                if (dateEventMap[date].has(event)) {
                    alert("The same event cannot be repeated on the same day.");
                    return false;
                }
                dateEventMap[date].add(event);
            }
            return true;
        }

        function validateForm(event) {
            if (!validateDates()) {
                event.preventDefault(); // Prevent form submission if date validation fails
                return;
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="post" onsubmit="validateForm(event)">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['Name']); ?>" required><br>
            <label>Age:</label>
            <input type="number" name="age" value="<?php echo htmlspecialchars($user['Age']); ?>" required><br>
            <label>Gender:</label>
            <select name="gender">
                <option value="male" <?php if ($user['Gender'] === 'male') echo 'selected'; ?>>Male</option>
                <option value="female" <?php if ($user['Gender'] === 'female') echo 'selected'; ?>>Female</option>
                <option value="other" <?php if ($user['Gender'] === 'other') echo 'selected'; ?>>Other</option>
            </select><br>
            <label>Phone Number:</label>
            <input type="text" name="phonenum" value="<?php echo htmlspecialchars($user['Phonenum']); ?>" required><br>
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required><br>

            <h2>Events</h2>
            <div id="eventsContainer">
                <?php foreach ($events as $index => $event): ?>
                <div class="event-row">
                    <label>Event:</label>
                    <select name="events[]" onchange="updatePrice(this)" required>
                        <option value="">Select Event</option>
                        <option value="listen" <?php if ($event['event'] === 'listen') echo 'selected'; ?>>Listening Event</option>
                        <option value="game" <?php if ($event['event'] === 'game') echo 'selected'; ?>>Gaming Event</option>
                        <option value="meetup" <?php if ($event['event'] === 'meetup') echo 'selected'; ?>>Meetup Event</option>
                        <option value="food" <?php if ($event['event'] === 'food') echo 'selected'; ?>>Food Event</option>
                    </select>
                    <label>Price:</label>
                    <input type="number" name="prices[]" value="<?php echo htmlspecialchars($event['price']); ?>" min="0" required>
                    <label>Date:</label>
                    <input type="date" name="dates[]" value="<?php echo htmlspecialchars($event['date']); ?>" min="2024-08-08" required>
                    <button type="button" class="remove-btn" onclick="removeEventRow(this)">Remove</button>
                    <span class="priceDisplay">Price: Rs. <?php echo htmlspecialchars($event['price']); ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <button type="button" onclick="addEventRow()">Add Another Event</button><br><br>

            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
