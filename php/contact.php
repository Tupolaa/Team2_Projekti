<?php
include("connect.php");

// Read form data
$name = isset($_POST["Name"]) ? trim($_POST["Name"]) : "";
$email = isset($_POST["Email"]) ? trim($_POST["Email"]) : "";
$message = isset($_POST["Viesti"]) ? trim($_POST["Viesti"]) : "";

// Redirect back to the form if necessary data is not provided
if (empty($name) || empty($email)){
    header("Location:../html/contact.html");
    exit;
}

// Prepare SQL query
$sql = "INSERT INTO Contact (Nimi, SPosti, Viesti) VALUES (?, ?, ?)";

// Prepare the statement
$stmt = mysqli_prepare($conn, $sql);
if ($stmt === false) {
    die("Error: " . mysqli_error($conn));
}

// Bind parameters
mysqli_stmt_bind_param($stmt, 'sss', $name, $email, $message);

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
