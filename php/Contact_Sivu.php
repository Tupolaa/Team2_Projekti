<?php
session_start();
if (!isset($_SESSION["kayttaja"])){
    header("Location:../html/kirjaudu.html");
    exit;
}
include ("../html/header.html");
include ("../html/Contact_Sivu.html");
include ("../html/footer.html");

?>