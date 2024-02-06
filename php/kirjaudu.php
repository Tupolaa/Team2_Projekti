<?php
session_start();
$json = isset($_POST["user"]) ? $_POST["user"] : "";

if (!($user = tarkistaJson($json))) {
    print "Täytä kaikki kentät";
    exit;
}

include("./connect.php");

// Prepare SQL query
$sql = "SELECT * FROM Tunnukset WHERE Tunnus=? AND Salasana=SHA2(?, 256)";
try {
    // Prepare SQL statement
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception(mysqli_error($conn));
    }
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, 'ss', $user->Tunnus, $user->Salasana);
    
    // Execute SQL statement
    mysqli_stmt_execute($stmt);
    
    // Get result
    $result = mysqli_stmt_get_result($stmt);
    
    // Check if there are any rows returned
    if (mysqli_num_rows($result) > 0) {
        // Fetch the first row
        $row = mysqli_fetch_object($result);
        
        // Store user information in session
        $_SESSION["kayttaja"] = $row->Tunnus;
        
        // Print "ok" as a success message
        print "ok";
        exit;
    } else {
        // Print an error message if no rows are returned
        print "Käyttäjätunnus tai salasana on väärä.";
        exit;
    }
} catch (Exception $e) {
    // Print error message if an exception occurs
    print "Jokin virhe!";
} finally {
    // Close the database connection
    mysqli_close($conn);
}

?>

<?php
function tarkistaJson($json) {
    if (empty($json)) {
        return false;
    }
    $user = json_decode($json);
    if (empty($user->Tunnus) || empty($user->Salasana)) {
        return false;
    }
    return $user;
}
?>
