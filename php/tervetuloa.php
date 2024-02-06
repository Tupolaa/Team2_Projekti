<?php
session_start();
if (!isset($_SESSION["kayttaja"])){
    header("Location:../html/kirjaudu.html");
    exit;
}
include "../html/header.html";
include "../admin.html";
include "../html/footer.html";
?>