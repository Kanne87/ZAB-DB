<?php
// Serververbindung aufbauen
include 'connect.php';
//Werte aus dem Formular holen
$kdid = $_POST["frmkdid"];
$sql = "DELETE FROM tblykunde WHERE id='".$kdid."';";
if ($conn->query($sql) === TRUE) {
    echo "Kartei gelöscht<br><a href=\"customers.php\">zurueck</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>

