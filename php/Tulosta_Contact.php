<?php
include("./connect.php");

$tulos = mysqli_query($conn, "SELECT * FROM Contact");
while ($rivi = mysqli_fetch_object($tulos)) {
    echo "ID: " . $rivi->ID . ", Nimi: " . $rivi->Name . ", Sähköposti: " . $rivi->Email . ", Viesti: " . $rivi->Message . "<br>";
}

mysqli_close($conn);
?>
