<?php

$vastaava = isset($_GET["vastaa"]) ? $_GET["vastaa"] : "";

if (empty($vastaava)){
    header("Location:./admin_panel.php");
    exit;
}

include ("./connect.php");

$sql = "SELECT * FROM Contact WHERE id=?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 'i', $vastaava);
mysqli_stmt_execute($stmt);
$tulos = mysqli_stmt_get_result($stmt);

if (!$rivi = mysqli_fetch_object($tulos)){
    header("Location:../html/tietuettaeiloydy.html");
    exit;
}

$recipientEmail = $rivi->Email; // Fetching email from the database
$senderEmail = 'teemu.tupolas@gmail.com'; // Sender's email

if (isset($_POST["name"]) && isset($_POST["message"])) {
    $emailSubject = 'Site contact form';
    $mailheader = "From: $senderEmail\r\n";
    $mailheader .= "Reply-To: $senderEmail\r\n";
    $mailheader .= "Content-type: text/html; charset=iso-8859-1\r\n";
    $messageBody = "Name: " . $_POST["name"] . "<br>";
    $messageBody .= "Message: " . nl2br($_POST["message"]) . "<br>";

    // Sending email to the recipient fetched from the database
    if (mail($recipientEmail, $emailSubject, $messageBody, $mailheader)) {
        echo "Your message was sent";
    } else {
        $lastError = error_get_last();
        echo "Failed to send message. Error: " . $lastError['message'];
    }


} else {
    ?>
    <form action="" method="post">
        <table width="400" cellspacing="2" cellpadding="0">
           <tr>
    <td width="29%" class="bodytext">Your name:</td>
    <td width="71%"><input name="name" type="text" id="name" size="32"></td>
</tr>

<tr>
    <td class="bodytext">Message:</td>
    <td><textarea name="message" cols="45" rows="6" id="message" class="bodytext"></textarea></td>
</tr>

            <tr>
                <td class="bodytext"> </td>
                <td valign="top"><input type="submit" name="Submit" value="Send"></td>
            </tr>
        </table>
    </form>
    <?php
};
?>
