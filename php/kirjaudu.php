<?php
session_start();
$json = isset($_POST["user"]) ? $_POST["user"] : "";

if (!($user = tarkistaJson($json))) {
    print "Täytä kaikki kentät";
    exit;
}

include("./connect.php");


$sql = "SELECT * FROM Tunnukset WHERE Tunnus=? AND Salasana=SHA2(?, 256)";
try {
   
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception(mysqli_error($conn));
    }
    
    
    mysqli_stmt_bind_param($stmt, 'ss', $user->Tunnus, $user->Salasana);
    

    mysqli_stmt_execute($stmt);
    
   
    $result = mysqli_stmt_get_result($stmt);
    

    if (mysqli_num_rows($result) > 0) {
     
        $row = mysqli_fetch_object($result);
        
     
        $_SESSION["kayttaja"] = $row->Tunnus;
        
        $username = $row->Tunnus;
        $logSql = "INSERT INTO LoginLogs (Name) VALUES (?)";
        $logStmt = mysqli_prepare($conn, $logSql);
        mysqli_stmt_bind_param($logStmt, 's', $username);
        mysqli_stmt_execute($logStmt);

     
        print "ok";
        exit;
    } else {
       
        print "Käyttäjätunnus tai salasana on väärä.";
        exit;
    }
} catch (Exception $e) {
   
    print "Jokin virhe!";
} finally {
 
    mysqli_close($conn);
}

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
