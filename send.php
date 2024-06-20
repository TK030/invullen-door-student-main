<?php

require_once 'db_connect.php';
require_once 'vendor/autoload.php';
require_once 'test.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $bewijs = $_GET['file'];
    $naamStudent = $_GET['name'];
    $bewijsIngeleverd = $_GET['bewijs'];

    // verstuur e-mail met bijlagen
    try {
        $mail = new PHPMailer(true);

        // SMTP configuratie
        $mail->IsSMTP();
        $mail->Timeout = 60;
        $mail->Mailer = "smtp";
        $mail->Host = "mail.smtp2go.com";
        $mail->Port = 465; // 8025, 587 and 25 can also be used. Use Port 465 for SSL.
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Username = 'taha2006@live.nl';  // SMTP username
        $mail->Password = 'BErQpAd2ghNH8odW';  // SMTP password

        $mail->setFrom('taha2006@live.nl', 'Mailer');
        $mail->FromName = "Taha Karaman";
        $mail->addAddress('taha2006@live.nl', 'Receiver');
        $mail->AddReplyTo('taha2006@live.nl', "Sender's Name");
        // $mail->addCC('a.kaouass@rocmn.nl', 'cc contact');

        // e-mailonderwerp en inhoud
        $mail->Subject = "Aanvraagformulier voor vrijstelling";
        $mail->Body = "Beste examencommissie,

Hierbij stuur ik u het aanvraagformulier voor vrijstelling.

" . ($bewijsIngeleverd ? "Bijgevoegd vindt u het bewijs." : "Er is geen bewijs bijgevoegd.") . "

Met vriendelijke groet,
$naamStudent";

        // bijlage toevoegen (bewijsbestand)
        if (!empty($bewijs) && file_exists($bewijs)) {
            $mail->addAttachment($bewijs);
        }

        // bijlage toevoegen (indiening)
        $mail->addAttachment($pdfPath, 'IndieningExamen.pdf');

        if (!$mail->Send()) {
            echo 'Message was not sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
            exit;
        } else {
            header('Location: success.php');
        }
    } catch (Exception $e) {
        echo "Bericht kon niet verstuurd worden. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo 'Failed to send the PDF file.';
}
