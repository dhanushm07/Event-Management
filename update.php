<?php
// update.php

// Database configuration
$servername = "localhost";
$username = "root"; // replace with your database username
$password = ""; // replace with your database password
$dbname = "eventmanagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'];
$name = $_POST['name'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$phonenum = $_POST['phonenum'];
$email = $_POST['email'];

$sql = "UPDATE register SET Name = ?, Age = ?, Gender = ?, Phonenum = ?, Email = ? WHERE Id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisssi", $name, $age, $gender, $phonenum, $email, $id);

if ($stmt->execute()) {
    header("Location: view.php");
} else {
    echo "Error updating record: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
