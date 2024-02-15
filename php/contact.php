<?php
// Sisällytetään tiedosto, joka sisältää tietokantayhteyden muodostamiseen tarvittavat tiedot
include("connect.php");

// Haetaan POST-muuttujista tiedot ja poistetaan ylimääräiset välilyönnit
$Nimi = isset($_POST["Nimi"]) ? trim($_POST["Nimi"]) : "";
$Sposti = isset($_POST["Sposti"]) ? trim($_POST["Sposti"]) : "";
$Viesti = isset($_POST["MSG"]) ? trim($_POST["MSG"]) : "";

// Tarkistetaan, onko Nimi- tai Sposti-kenttä tyhjä
if (empty($Nimi) || empty($Sposti)){
    // Jos jompikumpi kenttä on tyhjä, ohjataan käyttäjä takaisin yhteydenottolomakkeelle
    header("Location:../html/contact.html");
    exit;
}

// Valmistellaan SQL-kysely tietojen lisäämiseksi tietokantaan
$sql = "INSERT INTO Contact (Name, Email, Message) VALUES (?, ?, ?)";

// Valmistellaan SQL-lauseke tietokannalle
$stmt = mysqli_prepare($conn, $sql);
// Tarkistetaan, onko lausekkeen valmistelu epäonnistunut
if ($stmt === false) {
    die("Error: " . mysqli_error($conn));
}

// Liitetään muuttujat SQL-lausekkeeseen
mysqli_stmt_bind_param($stmt, 'sss', $Nimi, $Sposti, $Viesti);
// Suoritetaan SQL-lauseke
$result = mysqli_stmt_execute($stmt);
// Tarkistetaan, onko lausekkeen suorittaminen epäonnistunut
if ($result === false) {
    die("Error: " . mysqli_error($conn));
} 

// Suljetaan tietokantayhteys
mysqli_close($conn);

// Ohjataan käyttäjä takaisin etusivulle
header("Location:../html/index.html");
exit;
?>
