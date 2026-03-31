<?php
session_start();
include ("../includes/connection.php");

$id = $_POST["id"] ?? '';
$naam = $_POST["naam"]?? '';
$email = $_POST["email"]?? '';
$datum = $_POST["datum"]?? '';
$tijd = $_POST["tijd"]?? '';


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $naam = $_POST["naam"];
    $email = $_POST["email"];

    // Hiermee stel je automatisch een vaste datum en tijd in
    $datum = "2026-04-01";
    $tijd  = "12:00:00";

    $stmt = $conn->prepare("INSERT INTO tb_tickets(naam, email, datum, tijd) VALUES (?, ?, ?, ?)");
    $stmt->execute([$naam, $email, $datum, $tijd]);

    header("Location: order.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <br>
    <a href="order.php">Terug naar de homepage</a>
</body>
</html>
