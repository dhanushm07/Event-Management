<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 70vh;
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

        .form-group input {
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

        .center {
            text-align: center;
            margin-bottom: 20px;
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
        function register() {
            window.location.href = "http://localhost/learning/eventmanagement/eventregister.php";
        }
    </script>
</head>
<body>
    <div class="container">
        <h1 class="center">Login Page</h1>
        <form action="eventlogin.php" method="post">
            <div class="form-group">
                <label for="name">Enter Username:</label>
                <input type="text" name="usname" id="name" required>
            </div>

            <div class="form-group">
                <label for="pass">Enter Password:</label>
                <input type="password" name="pass" id="pass" required>
            </div>

            <div class="button-container">
			<button type="submit" name="submit">Submit</button>
             
                <button type="button" onclick="register()">New User Registration</button>
            </div>
        </form>

        <?php
        if (isset($_POST["submit"])) {
            $user = $_POST["usname"];
            $pass = $_POST["pass"];

            $host = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "eventmanagement";

            $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $query = "SELECT l.Username FROM login l 
                      JOIN register r ON l.Eid = r.Id 
                      WHERE l.Username='$user' AND l.Password='$pass' AND r.Deleted=0";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) == 1) {
                session_start();
                $_SESSION['username'] = $user;

                if ($user == "admin") {
                    header("Location: adminpanel.php");
                } else {
                    header("Location: homepage.php");
                }
                exit();
            } else {
                echo "Invalid username or password.";
            }

            mysqli_close($conn);
        }
        ?>
    </div>
</body>
</html>
