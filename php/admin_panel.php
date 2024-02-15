<?php
// Käynnistetään istunto
session_start();
// Tarkistetaan, onko käyttäjää kirjautunut sisään
if (!isset($_SESSION["kayttaja"])){
    // Jos käyttäjä ei ole kirjautunut sisään, ohjataan hänet kirjautumissivulle
    header("Location:../html/kirjaudu.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Metatietoja ja tyylitiedostoja -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adminpanel.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <title>Admin Page</title>
</head>
<body>

<!-- Ylänavi ja kirjaudu ulos -linkki -->
<div class="topnav">
    <ul id="fontti">
        <li><a href="kirjauduulos.php">Kirjaudu Ulos</a></li>
    </ul>
</div>

<!-- Sisältöalue -->
<div class="content">
    <!-- Navigointi ja napit kontaktien ja kirjautumisten lukemiselle -->
    <nav>
        <button onclick='ReadContacts();'>Contacts</button>
        <p id='contactjson'>
        Tulosta tähän
        </p>
        <button onclick='ReadLogin();'>Logs</button>
        <p id='Logjson'>
        Tulosta tähän</p>
    </nav>
</div>

<!-- Alatunniste ja linkit -->
<div class="footer">
    <ul>
        <li><a href="../html/index.html">Main Page</a></li>
        <li><a href='./email.php?vastaa=$rivi->id'>Answer Email</a></li>
    </ul>
</div>

<!-- JavaScript-funktiot kontaktien ja kirjautumisten lukemiselle -->
<script>
    function ReadContacts() {
        // Luodaan XMLHttpRequest-objekti
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Vastaanotetaan JSON-data ja päivitetään HTML-elementti
                json = this.responseText;
                document.getElementById("contactjson").innerHTML = json;
                Contacts = JSON.parse(json);
            }
        };
        // Lähetetään GET-pyyntö PHP-skriptille kontaktitietojen lukemiseksi
        xmlhttp.open("GET", "../php/Tulosta_Contact.php", true);
        xmlhttp.send();
    }
</script>
<script>
    function ReadLogin() {
        // Luodaan XMLHttpRequest-objekti
        xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Vastaanotetaan JSON-data ja päivitetään HTML-elementti
                json = this.responseText;
                document.getElementById("Logjson").innerHTML = json;
                Contacts = JSON.parse(json);
            }
        };
        // Lähetetään GET-pyyntö PHP-skriptille kirjautumistietojen lukemiseksi
        xmlhttp.open("GET", "../php/Tulosta_Login.php", true);
        xmlhttp.send();
    }
</script>
<div class="footer">
    <ul>
    <li><a href="../html/index.html">Main Page</a></li>
    <li><a href='./email.php?vastaa=$rivi->id'>Answer Email</a></li>
    </ul>
</div>
</body>
</html>
