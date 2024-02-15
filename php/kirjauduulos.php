<?php
// Käynnistetään istunto
session_start();

// Poistetaan istunnosta käyttäjän tiedot
unset($_SESSION["kayttaja"]);

// Ohjataan käyttäjä kirjautumissivulle
header("Location:../html/kirjaudu.html");
?>
