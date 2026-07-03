<?php
$servername = "localhost"; // Change this to your database server
$username = "root"; // Database username
$password = ""; // Database password (if any)
$dbname = "powerzone_db"; // Your database name

// Create connection
$conn = new mysqli('localhost', 'root' , '' , 'powerzone_db');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>



