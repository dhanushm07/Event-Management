<!DOCTYPE html>
<html>
<head>
    <title>Mail Sending</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 15px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
        }
        h2 {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
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
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        button {
            background: #28a745;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        button:hover {
            background: #218838;
        }
        button:active {
            background: #1e7e34;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination button {
            background: #007bff;
            color: white;
            margin: 3px;
        }
        .pagination button:hover {
            background: #0056b3;
        }
        .pagination button:disabled {
            background: #c0c0c0;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <h1>Send Mail to the Participants</h1>
    <h2>Hey Admin...</h2>

    <table border="1" id="mytable">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Send Mail</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $host = "localhost";
            $dbusername = "root";
            $dbpassword = "";
            $dbname = "eventmanagement";
            $conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }

            $query = "SELECT * FROM register";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr data-id='" . $row["Id"] . "'>
                        <td data-field='Name'>" . htmlspecialchars($row["Name"]) . "</td>
                        <td data-field='Email'>" . htmlspecialchars($row["Email"]) . "</td>
                        <td><button onclick='sendMail(\"" . htmlspecialchars($row["Email"]) . "\")'>Send Mail</button></td>
                    </tr>";
                }
            }

            mysqli_close($conn);
            ?>
        </tbody>
    </table>

    <div class="pagination" id="pagination">
        <button id="firstPage">First</button>
        <button id="prevPage">Previous</button>
        <span id="pageNumbers"></span>
        <button id="nextPage">Next</button>
        <button id="lastPage">Last</button>
    </div>
	<br><br>
    <center>
        <button onclick="adminpanel()">Go back to admin panel</button>
		
    </center>

    <script>
        const rowsPerPage = 25;
        let currentPage = 1;
        const rows = Array.from(document.querySelectorAll('#mytable tbody tr'));
        const pagination = document.getElementById('pagination');
        const pageNumbers = document.getElementById('pageNumbers');

        function paginate() {
            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            rows.forEach((row, index) => {
                row.style.display = index >= start && index < end ? '' : 'none';
            });
            updatePaginationControls();
        }

        function updatePaginationControls() {
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            pageNumbers.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.textContent = i;
                button.addEventListener('click', () => {
                    currentPage = i;
                    paginate();
                });
                pageNumbers.appendChild(button);
            }
            document.getElementById('firstPage').disabled = currentPage === 1;
            document.getElementById('prevPage').disabled = currentPage === 1;
            document.getElementById('nextPage').disabled = currentPage === totalPages;
            document.getElementById('lastPage').disabled = currentPage === totalPages;
        }

        document.getElementById('firstPage').addEventListener('click', () => {
            currentPage = 1;
            paginate();
        });

        document.getElementById('prevPage').addEventListener('click', () => {
            if (currentPage > 1) {
                currentPage--;
                paginate();
            }
        });

        document.getElementById('nextPage').addEventListener('click', () => {
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                paginate();
            }
        });

        document.getElementById('lastPage').addEventListener('click', () => {
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            currentPage = totalPages;
            paginate();
        });

        // Initialize pagination
        paginate();

        function sendMail(email) {
            if (confirm("Do you really want to send mail to " + email + "?")) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "send_email.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

                var data = "email=" + encodeURIComponent(email);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            alert("Email sent successfully!");
                        } else {
                            alert("Failed to send email: " + xhr.responseText);
                        }
                    }
                };

                xhr.send(data);
            }
        }
		function adminpanel() {
            window.location.href = 'adminpanel.php';
        }
    </script>
</body>
</html>
