<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_spik&span"; // Change this to your actual database name

// Create connection
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);

// Check connection

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

?>
