<?php
include("connect.php");


$Nimi = isset($_POST["Nimi"]) ? trim($_POST["Nimi"]) : "";
$Sposti = isset($_POST["Sposti"]) ? trim($_POST["Sposti"]) : "";
$Viesti = isset($_POST["MSG"]) ? trim($_POST["MSG"]) : "";

if (empty($Nimi) || empty($Sposti)){
    header("Location:../html/contact.html");
    exit;
}
$sql = "INSERT INTO Contact (Name, Email, Message) VALUES (?, ?, ?)";

$stmt = mysqli_prepare($conn, $sql);
if ($stmt === false) {
    die("Error: " . mysqli_error($conn));
}
mysqli_stmt_bind_param($stmt, 'sss', $Nimi, $Sposti, $Viesti);
$result = mysqli_stmt_execute($stmt);
if ($result === false) {
    die("Error: " . mysqli_error($conn));
} 

mysqli_close($conn);
header("Location:../html/index.html");
exit;
?>
