<?php
$initials=parse_ini_file("../.ht/.ht.asetukset.ini");
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try{
    $conn=mysqli_connect($initials["palvelin"], $initials["tunnus"], $initials["pass"], $initials["db"]);
}
catch(Exception $e){
    header("Location:../yhteysvirhe.html");
    exit;
}
?>