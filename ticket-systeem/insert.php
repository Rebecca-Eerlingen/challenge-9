<?php
session_start();
include("../includes/connection.php");

// Load PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php';

// dit betekend dat het script kijkt 
// welke methode word gebruikt om de pagina te laden
if ($_SERVER["REQUEST_METHOD"] === "POST") {

//dit haalt de data uit wat je hebt ingevult
    $naam  = $_POST["naam"] ?? '';
    $email = $_POST["email"] ?? '';
    $datum = $_POST["datum"] ?? '';
    $tijd  = "18:00:00";

    if (!empty($naam) && !empty($email)) {
        // insert het in de data base
        $stmt = $conn->prepare("INSERT INTO tb_tickets(naam, email, datum, tijd) VALUES (?, ?, ?, ?)");
        $stmt->execute([$naam, $email, $datum, $tijd]);
        
        // Haalt het ID van de ticket en stuurt een email link
        $newTicketId = $conn->lastInsertId();

        // Stuurt de email
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true;
            $mail->Username   = 'rebeccaeerlingen@gmail.com';
            $mail->Password   = 'jxbu huen gbut epdg';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('rebeccaeerlingen@gmail.com', 'Spik & Span Events');
            $mail->addAddress($email, $naam); // Sends to the address from the form

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Je ticket voor Spik & Span!';
            $mail->Body    = "
                <h1>Bedankt voor je bestelling, $naam!</h1>
                <p> (als je dit leest ben je een kleine bitch) <p>
                <p>Je ticket voor de show op $datum om $tijd is gereserveerd.</p>
                <p> Jouw ID is $newTicketId </p>
                <p>Je kunt je digitale ticket hier bekijken:</p>
                <a href='http://localhost/ticket.php?id=$newTicketId'>Bekijk mijn Ticket</a>
            ";

            $mail->SMTPDebug = 4;
            $mail->send();
        } catch (Exception $e) {
            echo "Mailing error: " . $mail->ErrorInfo;
        }

        // 3. Redirect to order page
        header("Location: order.php?success=1");
        exit;
    }
}
?>