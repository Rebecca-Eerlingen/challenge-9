<?php

// Maakt verbinding met de MySQL-server
// "localhost" = serveradres
// "root" = gebruikersnaam
// "" = wachtwoord (leeg in dit geval)
$link = mysqli_connect("localhost", "root", "");

// Selecteert de database die gebruikt moet worden
mysqli_select_db($link, "db_spik&span");

// Maakt een lege array aan
// Hierin worden later de gegevens opgeslagen voor de grafiek
$test = array();


$count = 0;

// Voert een SQL-query uit
// Hiermee worden alle gegevens opgehaald uit de tabel tb_tickets
$res = mysqli_query($link, "
        SELECT 
        DATE(koopdatum) as datum,
    COUNT(*) as totaal
    FROM tb_tickets
    GROUP BY DATE(koopdatum)
    ORDER BY DATE(koopdatum)
    ");


// Loopt door alle gegevens heen uit de database
while($row = mysqli_fetch_array($res))
{
    // Zet de waarde van kolom als label
    // Dit wordt later gebruikt als tekst onder de grafiekbalk
    $test[$count]["label"] = $row["datum"];

    // Zet de waarde van kolom "id" in y
    // (int) zorgt ervoor dat het een getal wordt
    // Dit wordt de hoogte van de balk in de grafiek
    $test[$count]["y"] = (int)$row["totaal"];

    // Verhoogt de teller met 1
    $count++;
}

?>

<!DOCTYPE HTML>
<html>

<head>

<script>

// Deze functie wordt uitgevoerd zodra de pagina volledig geladen is
window.onload = function () {

    // Maakt een nieuwe grafiek aan hiervoor wordt canvajs gebruikt (dat is gewoon een programma van het internet)
    var chart = new CanvasJS.Chart("chartContainer", {

        // animatie
        animationEnabled: true,

        // Zorgt ervoor dat de grafiek gedownload kan worden
        exportEnabled: true,

        // De thema van de grafiek
        // Mogelijkheden: light1, light2, dark1, dark2
        theme: "light2",

        // Titel
        title:{
            text: "spik & span kaart verkoop"
        },

        // Instellingen voor de Y-as
        axisY:{
            // Zorgt ervoor dat de Y-as bij 0 begint
            includeZero: true
        },

        // Gegevens van de grafiek
        data: [{

            // Type grafiek
            // Mogelijkheden: column, bar, line, pie, area, etc.
            type: "column",

            // Toont eventueel de y-waarde boven de balken
            // Staat nu uit omdat het commentaar is
            // indexLabel: "{y}",

            // Kleur van de labels
            indexLabelFontColor: "#5A5757",

            // Plaats van de labels
            indexLabelPlacement: "outside",

            // PHP-array omzetten naar JSON voor JavaScript
            // JSON_NUMERIC_CHECK zorgt dat getallen echt numeriek blijven
            dataPoints: <?php echo json_encode($test, JSON_NUMERIC_CHECK); ?>

        }]
    });

    // Tekent/rendered de grafiek op de pagina
    chart.render();

}

</script>

</head>

<body>

<!-- Div waarin de grafiek wordt weergegeven -->
<div id="chartContainer" style="height: 370px; width: 100%;"></div>

<!-- Laadt de CanvasJS bibliotheek -->
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

</body>
</html>