<?php
// db_connect.php

// Database connection settings (from your FreeHost / InfinityFree control panel)
$servername = "sql308.byetcluster.com";  // SQL hostname
$username   = "ezyro_41193808";     // Database username
$password   = "mnh7rkby";           // Database password
$dbname     = "ezyro_41193808_teslainventory"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
