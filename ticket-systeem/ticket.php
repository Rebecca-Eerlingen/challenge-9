<?php
include ("../includes/connection.php");

// get ticket id from URL
$id = $_GET['id'] ?? 0;

// fetch ONE ticket
$stmt = $conn->prepare("SELECT * FROM tb_tickets WHERE id = ?");
$stmt->execute([$id]);
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ticket) {
    echo "Ticket niet gevonden!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Jouw ticket</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="background">
    <div class="box">
        <h2> Jouw Ticket</h2>

        <p><strong>Naam:</strong> <?= htmlspecialchars($ticket['naam']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($ticket['email']) ?></p>
        <p><strong>Datum:</strong> <?= htmlspecialchars($ticket['datum']) ?></p>
        <p><strong>Tijd:</strong> <?= htmlspecialchars($ticket['tijd']) ?></p>
        <p><strong>qr:</strong> <?= htmlspecialchars($ticket['qr']) ?></p>
        

        <br>

        <!-- QR CODE -->
        <?php
        $data = urlencode("http://localhost/check.php?id=" . $ticket['id']);
        ?>
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= $data ?>">

    </div>
</div>

</body>
</html>