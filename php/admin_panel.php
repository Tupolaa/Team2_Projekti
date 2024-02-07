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
    <link rel="stylesheet" href="../css/adminpanel.css">
    <title>Admin Page</title>
</head>
<body>
    <a href='kirjauduulos.php'>Kirjaudu ulos</a>
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
    
    <button onclick='ReadContacts();'>Contacts</button>
    <p id='contactjson'>
        Tulos tähän
    </p>
    
    
    


</body>
</html>