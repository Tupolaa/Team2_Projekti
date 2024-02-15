<?php
// Käynnistetään istunto
session_start();

// Tarkistetaan, onko käyttäjä kirjautunut sisään
if (!isset($_SESSION["kayttaja"])){
    // Jos käyttäjä ei ole kirjautunut sisään, ohjataan hänet kirjautumissivulle ja lopetetaan skriptin suoritus
    header("Location:../html/kirjaudu.html");
    exit;
}

// Sisällytetään tiedosto, joka sisältää tietokantayhteyden muodostamiseen tarvittavat tiedot
include("./connect.php");

// Haetaan kaikki yhteydenottolomakkeen tiedot tietokannasta
$tulos = mysqli_query($conn, "SELECT * FROM Contact");

// Käydään läpi jokainen tietokannasta haettu rivi
while ($rivi = mysqli_fetch_object($tulos)) {
    // Tulostetaan rivin tiedot, kuten ID, Nimi, Sähköposti ja Viesti
    print "ID: " . $rivi->ID . ", Nimi: " . $rivi->Name . ", Sähköposti: " . $rivi->Email . ", Viesti: " . $rivi->Message . "<br>"; 
    // Luodaan linkki vastaamista varten ja välitetään ID vastaussivulle
    print "<a href='../html/email.html?vastaa={$rivi->ID}'> vastaa</a></p>";
}

// Suljetaan tietokantayhteys
mysqli_close($conn);
?>

