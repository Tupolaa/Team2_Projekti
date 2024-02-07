<?php
include("connect.php");

// Read form data
$Nimi = isset($_POST["Nimi"]) ? trim($_POST["Nimi"]) : "";
$Sposti = isset($_POST["Sposti"]) ? trim($_POST["Sposti"]) : "";
$Viesti = isset($_POST["MSG"]) ? trim($_POST["MSG"]) : "";

// Redirect back to the form if necessary data is not provided
if (empty($Nimi) || empty($Sposti)){
    header("Location:../html/contact.html");
    exit;
}

// Prepare SQL query
$sql = "INSERT INTO Contact (Name, Email, Message) VALUES (?, ?, ?)";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);
if ($stmt === false) {
    die("Error: " . mysqli_error($conn));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, 'sss', $Nimi, $Sposti, $Viesti);

// Execute the statement
$result = mysqli_stmt_execute($stmt);
if ($result === false) {
    die("Error: " . mysqli_error($conn));
} 

// Close the connection
mysqli_close($conn);

// Redirect to the index page
header("Location:../html/index.html");
exit;
?>
