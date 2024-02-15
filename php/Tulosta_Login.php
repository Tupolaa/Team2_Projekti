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

// Haetaan kaikki kirjautumislokit tietokannasta
$tulos = mysqli_query($conn, "SELECT * FROM LoginLogs");

// Käydään läpi jokainen tietokannasta haettu rivi
while ($rivi = mysqli_fetch_object($tulos)) {
    // Tulostetaan rivin tiedot, kuten ID, Nimi ja Kirjautumisaika
    print "ID: " . $rivi->id . ", Nimi: " . $rivi->Name . ", Aika: " . $rivi->loginTime ."<br>" ;
}

// Suljetaan tietokantayhteys
mysqli_close($conn);
?>
