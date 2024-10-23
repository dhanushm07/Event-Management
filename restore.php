<?php
$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "eventmanagement";
$conn = mysqli_connect($host, $dbusername, $dbpassword, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "UPDATE register SET deleted = 0 WHERE Id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
}

mysqli_close($conn);
header("Location: view.php");
exit;
?>
