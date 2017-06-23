<?php
// Serververbindung aufbauen
include 'connect.php';
//Werte aus dem Formular holen
$anrede = $_POST["frmanrede"];
$vorname = $_POST["frmvorname"];
$nachname = $_POST["frmnachname"];
$geburtsdatum = $_POST["frmgeburtsdatum"];
if($_POST["frmvorname2"]<>"") {
    $anrede2 = $_POST["frmanrede2"];
    $vorname2 = $_POST["frmvorname2"];
    $nachname2 = $_POST["frmnachname2"];
    $geburtsdatum2 = $_POST["frmgeburtsdatum2"];    
}
$id_kunde;
$id_kunde2;
$sql = "INSERT INTO tblykunde (id_anrede, vorname, nachname, geburtsdatum) VALUES ('".$anrede."', '".$vorname."', '".$nachname."', '".$geburtsdatum."');";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br><a href=\"customers.php\">zurueck</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$id_kunde = $conn->insert_id;
$sql = "INSERT INTO tblykunde (id_anrede, vorname, nachname, geburtsdatum) VALUES ('".$anrede2."', '".$vorname2."', '".$nachname2."', '".$geburtsdatum2."');";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br><a href=\"customers.php\">zurueck</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$id_kunde2 = $conn->insert_id;
$sql = "INSERT INTO tblykunde_beziehung (id_kunde, id_kunde_beziehung) VALUES ('".$id_kunde."', '".$id_kunde2."');";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully<br><a href=\"customers.php\">zurueck</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>