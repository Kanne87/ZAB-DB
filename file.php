<?php
include 'connect.php';
$cryptid = $_GET["ci"];
if ($result = $conn->query("SELECT pfad, cryptkey FROM viewkunde_dokument WHERE cryptkey = '".$cryptid."'")) {
while($daten = $result->fetch_object() ){
    $edit = "Location: ".$daten->pfad;
    $wurst = header($edit); 
}
}
?>