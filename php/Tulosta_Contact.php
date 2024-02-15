<?php
session_start();
if (!isset($_SESSION["kayttaja"])){
    header("Location:../html/kirjaudu.html");
    exit;
}
include("./connect.php");

$tulos = mysqli_query($conn, "SELECT * FROM Contact");
while ($rivi = mysqli_fetch_object($tulos)) {
    print "ID: " . $rivi->ID . ", Nimi: " . $rivi->Name . ", Sähköposti: " . $rivi->Email . ", Viesti: " . $rivi->Message . "<br>"; 
    print "<a href='../html/email.html?vastaa={$rivi->ID}'> vastaa</a></p>";

}

mysqli_close($conn);
?>
