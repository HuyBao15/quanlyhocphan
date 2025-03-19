<?php
$servername = "localhost";
$username = "root";
$password = ""; // Để trống nếu dùng XAMPP mặc định
$dbname = "Test1";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");
?>