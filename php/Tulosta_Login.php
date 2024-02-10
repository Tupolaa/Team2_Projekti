<?php
session_start();
if (!isset($_SESSION["kayttaja"])){
    header("Location:../html/kirjaudu.html");
    exit;
}
include("./connect.php");

$tulos = mysqli_query($conn, "SELECT * FROM LoginLogs");
while ($rivi = mysqli_fetch_object($tulos)) {
    echo "ID: " . $rivi->id . ", Nimi: " . $rivi->Name . ", Aika: " . $rivi->loginTime . "<br>";
}

mysqli_close($conn);
?>
