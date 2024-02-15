<?php
// Käynnistetään istunto
session_start();
// Otetaan vastaan JSON-data, joka sisältää käyttäjän tiedot
$json = isset($_POST["user"]) ? $_POST["user"] : "";

// Tarkistetaan, että JSON-data on annettu ja sisältää tarvittavat tiedot
if (!($user = tarkistaJson($json))) {
    // Jos tiedot puuttuvat, tulostetaan virheviesti ja lopetetaan skriptin suoritus
    print "Täytä kaikki kentät";
    exit;
}

// Sisällytetään tiedosto, joka sisältää tietokantayhteyden muodostamiseen tarvittavat tiedot
include("./connect.php");

// SQL-kysely käyttäjän tietojen tarkistamiseksi
$sql = "SELECT * FROM Tunnukset WHERE Tunnus=? AND Salasana=SHA2(?, 256)";
try {
    // Valmistellaan SQL-kysely
    $stmt = mysqli_prepare($conn, $sql);
    if (!$stmt) {
        throw new Exception(mysqli_error($conn));
    }
    
    // Liitetään parametrit SQL-kyselyyn
    mysqli_stmt_bind_param($stmt, 'ss', $user->Tunnus, $user->Salasana);

    // Suoritetaan SQL-kysely
    mysqli_stmt_execute($stmt);
    
    // Haetaan kyselyn tulos
    $result = mysqli_stmt_get_result($stmt);

    // Jos käyttäjä löytyy tietokannasta
    if (mysqli_num_rows($result) > 0) {
        // Haetaan käyttäjätiedot
        $row = mysqli_fetch_object($result);
        
        // Tallennetaan käyttäjänimi istuntoon
        $_SESSION["kayttaja"] = $row->Tunnus;
        
        // Lisätään kirjautumistiedot kirjautumislogeihin
        $username = $row->Tunnus;
        $logSql = "INSERT INTO LoginLogs (Name) VALUES (?)";
        $logStmt = mysqli_prepare($conn, $logSql);
        mysqli_stmt_bind_param($logStmt, 's', $username);
        mysqli_stmt_execute($logStmt);

        // Palautetaan "ok", jos kirjautuminen onnistui
        print "ok";
        exit;
    } else {
        // Tulostetaan virheviesti, jos käyttäjätunnus tai salasana on väärä
        print "Käyttäjätunnus tai salasana on väärä.";
        exit;
    }
} catch (Exception $e) {
    // Tulostetaan virheviesti, jos tapahtuu virhe tietokantakyselyssä
    print "Jokin virhe!";
} finally {
    // Suljetaan tietokantayhteys
    mysqli_close($conn);
}

// Funktio tarkistaa, että annettu JSON-data on kelvollinen ja sisältää tarvittavat tiedot
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
