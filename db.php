<?php
$host = "localhost";
$user = "root"; // Default XAMPP user
$pass = ""; // No password by default
$db = "edusphere"; // database name

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
