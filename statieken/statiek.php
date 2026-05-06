<!-- connection to Spik&Span database -->
<?php
session_start();
include ("../includes/connection.php"); 
?>

<!--Statieken-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statieken</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Statiek overzicht</h1>
    <canvas id="ticketChart"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="stats.js"></script>
    <script src="ticketstats.py"></script>
    <script src="data.sql"></script>
</body>
</html>
