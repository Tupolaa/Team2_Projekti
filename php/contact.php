
<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try{
    $yhteys=mysqli_connect("db", "Ryhmatyo", "root", "password");
}
catch(Exception $e){
    header("Location:../html/yhteysvirhe.html");
    exit;
}

//Luetaan lomakkeelta tulleet tiedot funktiolla $_POST
//jos syötteet ovat olemassa
$name=isset($_POST["name"]) ? $_POST["name"] : "";
$email=isset($_POST["email"]) ? $_POST["email"] : "";
$message=isset($_POST["message"]) ? $_POST["message"] : "";

//Jos ei jompaa kumpaa tai kumpaakaan tietoa ole annettu
//ohjataan pyyntö takaisin lomakkeelle
if (empty($name) || empty($email)){
    header("Location:../html/contact.html");
    exit;
}

//Tehdään sql-lause, jossa kysymysmerkeillä osoitetaan paikat
//joihin laitetaan muuttujien arvoja
$sql="insert into contact (Name, Email, Message) values(?, ?, ?)";

//Valmistellaan sql-lause
$stmt=mysqli_prepare($yhteys, $sql);
//Sijoitetaan muuttujat oikeisiin paikkoihin
mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $message);
//Suoritetaan sql-lause
mysqli_stmt_execute($stmt);
//Suljetaan tietokantayhteys
mysqli_close($yhteys);

header("location:../html/index.html");
exit;
?>