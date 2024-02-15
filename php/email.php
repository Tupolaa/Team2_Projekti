<?php 
// Käynnistetään istunto
session_start();
// Tarkistetaan, onko käyttäjä kirjautunut sisään
if (!isset($_SESSION["kayttaja"])){
    // Jos käyttäjä ei ole kirjautunut sisään, ohjataan hänet kirjautumissivulle
    header("Location:../html/kirjaudu.html");
    exit;
}
// Sisällytetään tiedosto, joka sisältää tietokantayhteyden muodostamiseen tarvittavat tiedot
include("./connect.php");

// Sisällytetään PHPMailer-kirjaston tiedostot
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception; 
require 'Mailer/Exception.php'; 
require 'Mailer/PHPMailer.php'; 
require 'Mailer/SMTP.php'; 

// Tarkistetaan, onko lomake lähetetty
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Luo PHPMailer-instanssi; Aseta `true` mahdollisten virheiden varalta
    $mail = new PHPMailer(true); 

    try {
        // Haetaan vastaanottajan sähköposti tietokannasta
        $sql = "SELECT Email FROM Contact WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_POST['recipient_id']); // Olettaen, että lomakkeella on kenttä nimeltä 'recipient_id', jossa on vastaanottajan ID
        $stmt->execute();
        $stmt->bind_result($recipientEmail);
        $stmt->fetch();
        $stmt->close();

        // Asetetaan Gmail SMTP-palvelimen asetukset
        $mail->isSMTP();                        // Aseta postinlähetin käyttämään SMTP:tä 
        $mail->Host = 'smtp.gmail.com';         // Määritä pää- ja varmuuskopiointi SMTP-palvelimet 
        $mail->SMTPAuth = true;                 // Ota SMTP-autentikointi käyttöön 
        $mail->Username = 'Aggress';            // Gmail-osoitteesi 
        $mail->Password = 'Password';           // Gmail-salasanasi 
        $mail->SMTPSecure = 'ssl';              // Ota käyttöön TLS-salaus, hyväksyy myös 'ssl' 
        $mail->Port = 465;                      // TCP-portti, johon yhdistetään 

        // Lähettäjän tiedot
        $mail->setFrom('sender@example.com', 'SenderName'); // Aseta lähettäjän sähköpostiosoite
        $mail->addReplyTo('reply@example.com', 'SenderName'); // Aseta vastausosoite

        // Lisää vastaanottaja
        $mail->addAddress($recipientEmail); // Aseta vastaanottajan sähköpostiosoite

        // Aseta sähköpostin muoto HTML:ksi
        $mail->isHTML(true); 

        // Sähköpostin aihe ja viestin sisältö lomakkeelta
        $mail->Subject = $_POST['email_title']; // Aseta sähköpostin aihe
        $mail->Body = $_POST['email_message']; // Aseta sähköpostin viesti

        // Lähetä sähköposti
        $mail->send();
        echo 'Message has been sent.';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>

