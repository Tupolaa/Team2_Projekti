<?php
session_start();
if (!isset($_SESSION["kayttaja"])){
    header("Location:../html/kirjaudu.html");
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/adminpanel.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <title>Admin Page</title>
    <style>

    </style>
</head>
<body>

<div class="topnav">
    <ul id="fontti">
        <li><a href="kirjauduulos.php">Kirjaudu Ulos</a></li>

    </ul>
</div>


<div class="content">

    <nav>
            <button onclick='ReadContacts();'>Contacts</button>
            <p id='contactjson'>
            Tulosta tähän
            </p>
            
    
            <button onclick='ReadLogin();'>Logs</button>
            <p id='Logjson'>
            Tulosta tähän</p>
    </nav>
<script>
        function ReadContacts() {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    json = this.responseText;
                    document.getElementById("contactjson").innerHTML = json;
                    Contacts = JSON.parse(json);

                }
            };
            xmlhttp.open("GET", "../php/Tulosta_Contact.php", true);
            xmlhttp.send();
        }

    </script>
    <script>
        function ReadLogin() {
            xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    json = this.responseText;
                    document.getElementById("Logjson").innerHTML = json;
                    Contacts = JSON.parse(json);

                }
            };
            xmlhttp.open("GET", "../php/Tulosta_login.php", true);
            xmlhttp.send();
        }

    </script>

</div>


  <div class="footer">
    <ul>
    <li><a href="../html/index.html">Main Page</a></li>
    <li><a href='./email.php?vastaa=$rivi->id'>Answer Email</a></li>
    </ul>
</div>

</body>
</html>