<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fotox";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally set the charset to utf8
$conn->set_charset("utf8");
?>
