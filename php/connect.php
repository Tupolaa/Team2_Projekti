<?php
// Luetaan asetukset ini-tiedostosta
$initials = parse_ini_file("../.ht/.ht.asetukset.ini");

// Asetetaan mysqli:n raportointityyli virheiden varalta
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Yhdistetään tietokantaan käyttäen luettuja asetuksia
    $conn = mysqli_connect($initials["palvelin"], $initials["tunnus"], $initials["pass"], $initials["db"]);
} catch (Exception $e) {
    // Jos yhdistäminen epäonnistuu, ohjataan käyttäjä virhesivulle ja lopetetaan skriptin suoritus
    header("Location:../html/virhe.html");
    exit;
}
?>
