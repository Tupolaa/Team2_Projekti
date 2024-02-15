<?php 


session_start();
if (!isset($_SESSION["kayttaja"])){
    header("Location:../html/kirjaudu.html");
    exit;
}
include("./connect.php");

// Include PHPMailer library files 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\SMTP; 
use PHPMailer\PHPMailer\Exception; 
require 'Mailer/Exception.php'; 
require 'Mailer/PHPMailer.php'; 
require 'Mailer/SMTP.php'; 

// Assuming you have already connected to your database and have a $conn variable available.

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Create an instance; Pass `true` to enable exceptions 
    $mail = new PHPMailer(true); 

    try {
        // Fetch recipient's email from database
        $sql = "SELECT Email FROM Contact WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $_POST['recipient_id']); // Assuming you have a form field named 'recipient_id' holding the ID of the recipient
        $stmt->execute();
        $stmt->bind_result($recipientEmail);
        $stmt->fetch();
        $stmt->close();

     // Server settings for Gmail SMTP
        $mail->isSMTP();                        // Set mailer to use SMTP 
        $mail->Host = 'smtp.gmail.com';         // Specify main and backup SMTP servers 
        $mail->SMTPAuth = true;                 // Enable SMTP authentication 
        $mail->Username = 'batterysuomi@gmail.com';   // Your Gmail address 
        $mail->Password = 'Battery2024';     // Your Gmail password 
        $mail->SMTPSecure = 'ssl';              // Enable TLS encryption, `ssl` also accepted 
        $mail->Port = 465;                      // TCP port to connect to 


        // Sender info 
        $mail->setFrom('sender@example.com', 'SenderName'); 
        $mail->addReplyTo('reply@example.com', 'SenderName'); 

        // Add a recipient 
        $mail->addAddress($recipientEmail); 

        // Set email format to HTML 
        $mail->isHTML(true); 

        // Mail subject and body content from form
        $mail->Subject = $_POST['email_title'];
        $mail->Body = $_POST['email_message'];

        // Send email 
        $mail->send();
        echo 'Message has been sent.';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    }
}
?>
