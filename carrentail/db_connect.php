<?php
$servername = "localhost";
$username = "root";  // Change this to your MySQL username
$password = "";  // Change this to your MySQL password
$dbname = "carrentalsystem";  // The name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
