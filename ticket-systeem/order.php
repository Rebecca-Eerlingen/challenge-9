<?php
// Zet foutmeldingen aan (handig tijdens ontwikkelen)
ini_set ('display_errors',1);
ini_set ('display_startup_errors',1);
error_reporting (E_ALL);

// Verbind met de database (connection.php bevat je PDO connectie)
include ("../includes/connection.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ticket page</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="navbar">
        <div class="logo">spik & span</div>
    </div>

    <div class="background">

        <div class="box">
            <h2>
                bestel je tickets!
            </h2>

            <!-- FORM: stuurt data naar insert.php -->
            <form action="insert.php" method="POST" class="insert-form">
                naam
                <input name="naam" required type="text" placeholder="naam">
                email
                <input type="text" name="email" required class="email" placeholder="email">

                <br><br>
                <input class="order-button" type="submit" value="bestel jouw kaartje">
                <br><br> 
        </div>


        </form>
    </div>

        <p>

<?php

// DATA OPHALEN UIT DATABASE

// haalt alle tickets op
$stmt = $conn->query("SELECT * FROM tb_tickets ORDER BY id DESC");
// Zet resultaten om in een array
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!-- refresh pagina -->
<a href="order.php">Reset</a>


<!-- TABEL MET DATA -->

<table class="table">

    <!-- Tabel headers -->
    <tr>
        <th class="id">id</th>
        <th class="naam">naam</th>
        <th class="email">email</th>
        <th class="datum">datum</th>
        <th class="tijd">tijd</th>
    </tr>

    <!-- Loop door alle rijen uit database -->
    <?php foreach ($rows as $row): ?>

        <tr>
            <!-- htmlspecialchars voorkomt XSS.
            xss is een kwetsbaarheid waarbij hackers
            slechte scripts in websites invoegen 
            met als doel deze in de browser van een gebruiker uit te voeren -->
            <td><?= htmlspecialchars($row['id']) ?></td>
            <td><?= htmlspecialchars($row['naam']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['datum']) ?></td>
            <td><?= htmlspecialchars($row['tijd']) ?></td>
        </tr>
        
        

    <?php endforeach; ?>

</table>


</body>
</html>
