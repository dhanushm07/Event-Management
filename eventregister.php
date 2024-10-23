<?php
if (isset($_POST["submit"])) {
    // Fetch form data
    $name = $_POST["name"];
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $phone = $_POST["phnumber"];
    $mail = $_POST["mail"];
    $username = $_POST["usname"];
    $password = $_POST["pass"];
    $repassword = $_POST["repass"];

    $host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "eventmanagement";

    // Create connection
    $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Check if phone number or email already exists
    $query2 = "SELECT Id FROM register WHERE Phonenum = '$phone' OR Email = '$mail'";
    $result2 = mysqli_query($conn, $query2);

    if (mysqli_num_rows($result2) > 0) {
        echo '<script>alert("Error: Phone number or Email already exists."); window.location.href = "eventregistration.php";</script>';
    } else {
        // Insert into register table
        $sql1 = "INSERT INTO register (Name, Age, Gender, Phonenum, Email) VALUES ('$name', $age, '$gender', '$phone', '$mail')";

        if (mysqli_query($conn, $sql1)) {
            $user_id = mysqli_insert_id($conn);

            // Check for existing username
            $query = "SELECT Eid FROM login WHERE Username = '$username'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<script>alert("Error: Username already exists."); window.location.href = "eventregistration.php";</script>';
            } else {
                // Insert into login table
                $sql2 = "INSERT INTO login (Username, Password, Eid) VALUES ('$username', '$password', $user_id)";
                if (mysqli_query($conn, $sql2)) {
                    echo "User registered successfully with ID: $user_id<br>";
                    header("Location: eventlogin.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }

    // Close the connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html >
<head>
    <title>Event Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 1200px;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }

        .form-group label {
            width: 200px;
            font-weight: bold;
            margin-right: 10px;
        }

        .form-group input,
        .form-group select {
            flex: 1;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .form-group input[type="submit"],
        .form-group button {
            background: #5cb85c; /* Green background color */
            color: #fff; /* White text color */
            border: none; /* Remove border */
            padding: 15px 25px; /* Increase padding for wider buttons */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 18px; /* Increase font size */
            width: 100%; /* Make button take full width of its container */
            box-sizing: border-box; /* Ensure padding does not affect width */
            margin: 10px 0; /* Add vertical margin for spacing */
        }

        .form-group input[type="submit"]:hover,
        .form-group button:hover {
            background: #4cae4c; /* Darker green on hover */
        }

        .button-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
		button {
            background: #28a745; /* Green background color */
            color: #fff; /* White text color */
            border: none; /* Remove border */
            padding: 15px 25px; /* Increased padding */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 18px; /* Larger font size */
            margin: 10px; /* Spacing around button */
            transition: background 0.3s ease; /* Smooth background transition */
        }

        button:hover {
            background: #218838; /* Darker green on hover */
        }

        button:active {
            background: #1e7e34; /* Even darker green when button is clicked */
        }
    </style>
    <script>
        function login() {
            window.location.href = "http://localhost/learning/eventmanagement/eventlogin.php";
        }

        function validateForm() {
            var form = document.forms["registrationForm"];
            var name = form["name"].value.trim();
            var age = form["age"].value;
            var phone = form["phnumber"].value;
            var gender = form["gender"].value;
            var password = form["pass"].value;
            var repassword = form["repass"].value;
            var mail = form["mail"].value.trim();

            var errors = [];

            if (name === "" || /^[\s]+$/.test(name) || /\d/.test(name)) {
                errors.push("Name cannot be empty, just spaces, or contain numbers.");
            }
            if (isNaN(age) || age < 16 || age > 60) {
                errors.push("Age must be a number between 16 and 60.");
            }

            if (!/^\d{10}$/.test(phone)) {
                errors.push("Phone number must be exactly 10 digits.");
            }

            var passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            if (!passwordRegex.test(password)) {
                errors.push("Password must be at least 8 characters long, include at least one uppercase letter, one number, and one special character.");
            }

            if (password !== repassword) {
                errors.push("Passwords do not match.");
            }

            if (gender === "") {
                errors.push("Gender selection is required.");
            }

            var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.(com)$/;
            if (!emailPattern.test(mail)) {
                errors.push("Email must end with .com.");
            }

            if (errors.length > 0) {
                alert(errors.join("\n"));
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Event Registration Form</h1>
        <form name="registrationForm" action="eventregister.php" method="post" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Enter Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="age">Enter Age (16 to 60):</label>
                <input type="text" id="age" name="age" value="<?php echo isset($age) ? htmlspecialchars($age) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="gender">Select Gender:</label>
                <select id="gender" name="gender">
                    <option value="">Select gender</option>
                    <option value="male" <?php echo isset($gender) && $gender == 'male' ? 'selected' : ''; ?>>Male</option>
                    <option value="female" <?php echo isset($gender) && $gender == 'female' ? 'selected' : ''; ?>>Female</option>
                    <option value="other" <?php echo isset($gender) && $gender == 'other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="phnumber">Enter Contact Number:</label>
                <input type="text" id="phnumber" name="phnumber" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="mail">Enter Email:</label>
                <input type="text" id="mail" name="mail" value="<?php echo isset($mail) ? htmlspecialchars($mail) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="usname">SET Username:</label>
                <input type="text" id="usname" name="usname" value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="pass">SET Password:</label>
                <input type="password" id="pass" name="pass" value="<?php echo isset($password) ? htmlspecialchars($password) : ''; ?>">
            </div>

            <div class="form-group">
                <label for="repass">RE-SET Password:</label>
                <input type="password" id="repass" name="repass" value="<?php echo isset($repassword) ? htmlspecialchars($repassword) : ''; ?>">
            </div>

            <div class="button-container">
			<button type="submit" name="submit" value="Register">Register</button>
               
                <button type="button" onclick="login()">Registered-User Login</button>
            </div>
        </form>
    </div>
</body>
</html>
