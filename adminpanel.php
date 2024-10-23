<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <style>
      .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 1200px;
        }

        
       .container {
            background: #fff;
            padding: 80px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width:1200px;
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
		
        h1 {
            margin-top: 0; /* Remove top margin for better centering */
            margin-bottom: 20px; /* Space below the heading */
            color: Black; /* Optional: Change text color */
        }
    </style>
</head>
<body>
    <div class="container">
	<center>
        <h1>            Admin Panel</h1>  <center>
        <button onclick="view()">Users who are registered</button>
        <button onclick="mail()">Click-send mail to the users</button>
        <button onclick="count()">Count of the participants by date</button>
        <button onclick="graphical()">Graphical reprentation</button>
		
		<br><br><br>
		<center>
        <button onclick="logout()">Logout</button>
		
 </center>
    </div>

    <script>
        function view() {
            window.location.href = "http://localhost/learning/eventmanagement/view.php";
        }

        function mail() {
            window.location.href = "http://localhost/learning/eventmanagement/sendmail.php";
        }

              function count() {
            window.location.href = "http://localhost/learning/eventmanagement/count.php";
        }
		
		function logout() {
            window.location.href = "http://localhost/learning/eventmanagement/eventlogin.php";
        }
		        function graphical() {
            window.location.href = 'fetch_data.php';
        }
    </script>
</body>
</html>
