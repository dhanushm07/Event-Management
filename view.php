<!DOCTYPE html>
<html>
<head>
    <title>Event Management View Page</title>
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
        p {
            text-align: center;
            color: #555;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #e0e0e0; /* Grey background for header */
            cursor: pointer; /* Pointer cursor on hover */
        }
        th.sort-asc::after {
            content: " ▲"; /* Ascending arrow */
        }
        th.sort-desc::after {
            content: " ▼"; /* Descending arrow */
        }
        .pagination button, .filter-group button {
            margin: 3px;
            padding: 8px 12px;
            border: none;
            background-color: #5cb85c;
            color: white;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }
        .pagination button:hover, .filter-group button:hover {
            background-color: #4cae4c;
        }
        .filter-group select {
            padding: 6px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-right: 10px;
            font-size: 14px;
        }
        #totalRecords {
            margin-top: 10px;
            text-align: center;
            font-weight: bold;
        }
        button {
            background: #28a745; /* Green background color */
            color: #fff; /* White text color */
            border: none; /* Remove border */
            padding: 10px 15px; /* Adjusted padding for compact look */
            border-radius: 4px; /* Rounded corners */
            cursor: pointer; /* Pointer cursor on hover */
            font-size: 14px; /* Adjusted font size */
            margin: 5px; /* Adjusted margin */
            transition: background 0.3s ease; /* Smooth background transition */
        }
        button:hover {
            background: #218838; /* Darker green on hover */
        }
        button:active {
            background: #1e7e34; /* Even darker green when button is clicked */
        }
    </style>
</head>
<body>
    <h1>VIEW PAGE</h1>
    <h2>Hey Admin! Welcome...</h2>
    <p>Here you can see the people who are registered for the event</p>

    <div class="filter-group" id="filterOptions">
        <!-- Additional filter options will be added here -->
    </div>

    <label for="rowsPerPage">Rows per page:</label>
    <select id="rowsPerPage" onchange="updateRowsPerPage()">
        <option value="5">5</option>
        <option value="10" selected>10</option>
        <option value="15">15</option>
        <option value="20">20</option>
        <option value="25">25</option>
    </select>

    <div class="filter-group">
        <label><input type="radio" name="userStatus" value="all" checked> All Users</label>
        <label><input type="radio" name="userStatus" value="active"> Active Users</label>
        <label><input type="radio" name="userStatus" value="deleted"> Deleted Users</label>
    </div>

    <div id="totalRecords">Total Records: 0</div>

    <table id="mytable">
        <thead>
            <tr>
                <th data-field="Name">Name</th>
                <th data-field="Age">Age</th>
                <th data-field="Gender">Gender</th>
                <th data-field="Phonenum">Phonenum</th>
                <th data-field="Email">Email</th>
                <th data-field="Event">Event</th>
                <th data-field="Price">Price</th>
                <th data-field="Date">Date</th>
                <th data-field="Status">Status</th>
                <th data-field="ParticipantsCount">Participants Count</th>
                <th>Edit</th>
                <th>Delete/Restore</th>
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

            $statusFilter = isset($_GET['userStatus']) ? $_GET['userStatus'] : 'all';
            $orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'Name';

            // Fetch users and their event details
            $query = "
                SELECT r.*, 
                       GROUP_CONCAT(e.Event SEPARATOR ', ') AS Events, 
                       GROUP_CONCAT(e.Price SEPARATOR ', ') AS Prices,
                       GROUP_CONCAT(e.Date SEPARATOR ', ') AS Dates,
                       COUNT(e.event) AS participants_count
                FROM register r
                LEFT JOIN eventhistory e ON e.UID = r.Id
                WHERE r.deleted = CASE WHEN '$statusFilter' = 'deleted' THEN 1 ELSE r.deleted END
                GROUP BY r.Id
                ORDER BY r.$orderBy
            ";

            // Fetch total count of records
            $totalQuery = "
                SELECT COUNT(*) AS total
                FROM register r
                LEFT JOIN eventhistory e ON e.UID = r.Id
                WHERE r.deleted = CASE WHEN '$statusFilter' = 'deleted' THEN 1 ELSE r.deleted END
            ";

            $result = mysqli_query($conn, $query);
            $totalResult = mysqli_query($conn, $totalQuery);
            $totalRow = mysqli_fetch_assoc($totalResult);
            $totalRecords = $totalRow['total'];

            if ($result) {
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $status = $row["deleted"] == 0 ? "Active" : "Deleted";
                        echo "<tr data-id='" . $row["Id"] . "'>
                            <td data-field='Name'>" . htmlspecialchars($row["Name"]) . "</td>
                            <td data-field='Age'>" . htmlspecialchars($row["Age"]) . "</td>
                            <td data-field='Gender'>" . htmlspecialchars($row["Gender"]) . "</td>
                            <td data-field='Phonenum'>" . htmlspecialchars($row["Phonenum"]) . "</td>
                            <td data-field='Email'>" . htmlspecialchars($row["Email"]) . "</td>
                            <td data-field='Event'>" . htmlspecialchars($row["Events"]) . "</td>
                            <td data-field='Price'>" . htmlspecialchars($row["Prices"]) . "</td>
                            <td data-field='Date'>" . htmlspecialchars($row["Dates"]) . "</td>
                            <td data-field='Status'>" . htmlspecialchars($status) . "</td>
                            <td data-field='ParticipantsCount'>" . htmlspecialchars($row["participants_count"]) . "</td>
                            <td><a href='edit.php?id=" . $row["Id"] . "'><button>Edit</button></a></td>
                            <td><a href='" . ($status == "Active" ? "delete.php?id=" . $row["Id"] : "restore.php?id=" . $row["Id"]) . "'><button>" . ($status == "Active" ? "Delete" : "Restore") . "</button></a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='12'>No records found</td></tr>";
                }
            } else {
                echo "Error: " . mysqli_error($conn);
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
        <button onclick="logout()">Logout</button><br>
        <button onclick="adminpanel()">Go back to admin panel</button>
    </center>

    <script>
        let currentPage = 1;
        let rowsPerPage = parseInt(document.getElementById('rowsPerPage').value, 10);
        const rows = Array.from(document.querySelectorAll('#mytable tbody tr'));
        const pageNumbers = document.getElementById('pageNumbers');
        const totalRecordsDisplay = document.getElementById('totalRecords');
        let sortDirection = {
            Name: 'asc',
            Age: 'asc',
            Gender: 'asc',
            Phonenum: 'asc',
            Email: 'asc',
            Event: 'asc',
            Price: 'asc',
            Date: 'asc',
            Status: 'asc',
            ParticipantsCount: 'asc'
        };

        function updateFilters() {
            const filterOptions = document.getElementById('filterOptions');
            filterOptions.innerHTML = '';

            const eventFilter = document.createElement('select');
            eventFilter.innerHTML = `
                <option value="">Select Event</option>
                <option value="listen">Listen</option>
                <option value="game">Game</option>
                <option value="meetup">Meetup</option>
                <option value="food">Food</option>
            `;
            eventFilter.addEventListener('change', displayTable);
            filterOptions.appendChild(eventFilter);

            const ageFilter = document.createElement('select');
            ageFilter.innerHTML = `
                <option value="">Select Age</option>
                <option value="under20">Under 20</option>
                <option value="20-40">20-40</option>
                <option value="above40">Above 40</option>
            `;
            ageFilter.addEventListener('change', displayTable);
            filterOptions.appendChild(ageFilter);

            const genderFilter = document.createElement('select');
            genderFilter.innerHTML = `
                <option value="">Select Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            `;
            genderFilter.addEventListener('change', displayTable);
            filterOptions.appendChild(genderFilter);
        }

        function updateRowsPerPage() {
            rowsPerPage = parseInt(document.getElementById('rowsPerPage').value, 10);
            currentPage = 1;
            displayTable();
        }

        function displayTable() {
            const eventFilterValue = document.querySelector('#filterOptions select:nth-of-type(1)').value;
            const ageFilterValue = document.querySelector('#filterOptions select:nth-of-type(2)').value;
            const genderFilterValue = document.querySelector('#filterOptions select:nth-of-type(3)').value;
            const statusFilterValue = document.querySelector('input[name="userStatus"]:checked').value;

            const filteredRows = rows.filter(row => {
                const cells = row.children;
                const eventCell = cells[5].textContent.trim().toLowerCase();
                const ageCell = parseInt(cells[1].textContent.trim(), 10);
                const genderCell = cells[2].textContent.trim().toLowerCase();
                const statusCell = cells[8].textContent.trim().toLowerCase();

                const matchesEvent = !eventFilterValue || eventCell.includes(eventFilterValue.toLowerCase());
                const matchesAge = !ageFilterValue || (
                    (ageFilterValue === 'under20' && ageCell < 20) ||
                    (ageFilterValue === '20-40' && ageCell >= 20 && ageCell <= 40) ||
                    (ageFilterValue === 'above40' && ageCell > 40)
                );
                const matchesGender = !genderFilterValue || genderCell === genderFilterValue.toLowerCase();
                const matchesStatus = statusFilterValue === 'all' || statusCell === statusFilterValue.toLowerCase();

                return matchesEvent && matchesAge && matchesGender && matchesStatus;
            });

            const totalRecords = filteredRows.length;
            totalRecordsDisplay.textContent = `Total Records: ${totalRecords}`;

            const totalPages = Math.ceil(totalRecords / rowsPerPage);
            pageNumbers.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const pageButton = document.createElement('button');
                pageButton.textContent = i;
                pageButton.addEventListener('click', () => {
                    currentPage = i;
                    displayTable();
                });
                pageNumbers.appendChild(pageButton);
            }

            const start = (currentPage - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            const paginatedRows = filteredRows.slice(start, end);

            document.querySelector('#mytable tbody').innerHTML = paginatedRows.map(row => row.outerHTML).join('');
        }

        function sortTable(column) {
            const rows = Array.from(document.querySelectorAll('#mytable tbody tr'));
            const field = column.dataset.field;
            const direction = sortDirection[field] === 'asc' ? 'desc' : 'asc';

            rows.sort((rowA, rowB) => {
                const cellA = rowA.querySelector(`td[data-field="${field}"]`).textContent.trim();
                const cellB = rowB.querySelector(`td[data-field="${field}"]`).textContent.trim();
                
                if (direction === 'asc') {
                    return cellA.localeCompare(cellB);
                } else {
                    return cellB.localeCompare(cellA);
                }
            });

            document.querySelector('#mytable tbody').innerHTML = rows.map(row => row.outerHTML).join('');
            sortDirection[field] = direction;
            document.querySelectorAll('th').forEach(th => th.classList.remove('sort-asc', 'sort-desc'));
            column.classList.add(`sort-${direction}`);
        }

        document.querySelectorAll('th').forEach(th => {
            th.addEventListener('click', () => sortTable(th));
        });

        document.addEventListener('DOMContentLoaded', () => {
            updateFilters();
            displayTable();
        });

        // Add event listener for radio buttons to update table
        document.querySelectorAll('input[name="userStatus"]').forEach(radio => {
            radio.addEventListener('change', displayTable);
        });

        function logout() {
            // Redirect to logout page
            window.location.href = 'eventlogin.php';
        }

        function adminpanel() {
            // Redirect to admin panel
            window.location.href = 'adminpanel.php';
        }
    </script>
</body>
</html>
