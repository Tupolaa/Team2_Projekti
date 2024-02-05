<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $admin_username = "admin";
    $admin_password = "salasana123";

    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    if ($input_username == $admin_username && $input_password == $admin_password) {
        header("Location: admin_panel.php");
        exit();
    } else {
        echo "Virheellinen käyttäjänimi tai salasana!";
    }
}
?>
