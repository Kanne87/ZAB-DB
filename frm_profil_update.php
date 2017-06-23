<?php
 
// Serververbindung aufbauen
include 'connect.php';
//Werte aus dem Formular holen
$kdid = $_POST["frmkdid"];
$anrede = $_POST["frmanrede"];
$vorname = $_POST["frmvorname"];
$nachname = $_POST["frmnachname"];
$geburtsdatum = $_POST["frmgeburtsdatum"];
$mitpartner = $_POST["frmopt"];
$kdid_partner = $_POST["frmkdid2"];
$anrede_partner = $_POST["frmanrede2"];
$vorname_partner = $_POST["frmvorname2"];
$nachname_partner = $_POST["frmnachname2"];
$geburtsdatum_partner = $_POST["frmgeburtsdatum2"];

if ($geburtsdatum == 0){$geburtsdatum = "00.00.0000";}
if ($geburtsdatum_partner == 0){$geburtsdatum_partner = "00.00.0000";}
if ($mitpartner == "ohne" && $kdid_partner == 0) {          // ohne Partner, keine bestehende Beziehung = Hauptprofil wird aktualisiert
    $sql = "UPDATE tblykunde SET id_anrede = '".$anrede."', vorname = '".$vorname."', nachname = '".$nachname."', geburtsdatum = '".$geburtsdatum."' WHERE id = ".$kdid.";";
    if ($conn->query($sql) === TRUE) {
        echo "Kartei aktualisiert<br>ID: ".$kdid."<br>Anrede: ".$anrede."<br>Name: ".$vorname." ".$nachname."<br>Geburtsdatum: ".$geburtsdatum."<br><a href=\"customers.php\">zurueck</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} if ($mitpartner == "mit" && $kdid_partner == 0) {       // mit Partner, keine bestehende Beziehung = Hauptprofil wird aktualisiert / Partner wird angelegt
    $result = $conn->query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name='tblykunde' AND table_schema = DATABASE( ) ;");
    $row = $result->fetch_assoc();
    $act_id = $row['AUTO_INCREMENT'];
    $sql = "INSERT INTO tblykunde (id_anrede, vorname, nachname, geburtsdatum, id_partner) VALUES ('".$anrede_partner."', '".$vorname_partner."', '".$nachname_partner."', '".$geburtsdatum_partner."', '".$kdid."')";
    if ($conn->query($sql) === TRUE) {
        echo "Kartei angelegt<br>Anrede: ".$anrede_partner."<br>Name: ".$vorname_partner." ".$nachname_partner."<br>Geburtsdatum: ".$geburtsdatum_partner."<br>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $sql = "UPDATE tblykunde SET id_anrede = '".$anrede."', vorname = '".$vorname."', nachname = '".$nachname."', geburtsdatum = '".$geburtsdatum."', id_partner = '".$act_id."' WHERE id = '".$kdid."'";
    if ($conn->query($sql) === TRUE) {
        echo "Kartei aktualisiert<br>ID: ".$kdid."<br>Anrede: ".$anrede."<br>Name: ".$vorname." ".$nachname."<br>Geburtsdatum: ".$geburtsdatum."<br>";
        echo "<a href='http://localhost/customers.php'>zurück</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} if ($mitpartner == "ohne" && $kdid_partner != 0) {      // ohne Partner, mit bestehender Beziehung = Hauptprofil wird aktualisiert / Beziehung wird gelöscht, Kartei bleibt bestehen!!
    $sql = "UPDATE tblykunde SET id_anrede = '".$anrede."', vorname = '".$vorname."', nachname = '".$nachname."', geburtsdatum = '".$geburtsdatum."', id_partner = '0' WHERE id = ".$kdid.";";
    if ($conn->query($sql) === TRUE) {
        echo "Kartei aktualisiert, Beziehung gelöst<br>ID: ".$kdid."<br>Anrede: ".$anrede."<br>Name: ".$vorname." ".$nachname."<br>Geburtsdatum: ".$geburtsdatum."<br><a href=\"customers.php\">zurueck</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $sql = "UPDATE tblykunde SET id_anrede = '".$anrede_partner."', vorname = '".$vorname_partner."', nachname = '".$nachname_partner."', geburtsdatum = '".$geburtsdatum_partner."', id_partner = '0' WHERE id = ".$kdid_partner.";";
    if ($conn->query($sql) === TRUE) {
        echo "Kartei aktualisiert, beziehung gelöst<br>ID: ".$kdid_partner."<br>Anrede: ".$anrede_partner."<br>Name: ".$vorname_partner." ".$nachname_partner."<br>Geburtsdatum: ".$geburtsdatum_partner."<br><a href=\"customers.php\">zurueck</a>";
        echo "<a href'http://localhost/customers.php'>zurück</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} 


$conn->close();
?>

