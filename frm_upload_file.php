<?php

$idkategorie = $_POST["frmkategorie"];
$kdid = $_POST["frmkdid"];
$beschreibung = $_POST["frmbeschreibung"];
$dateipfad;

function random_string() {
 if(function_exists('random_bytes')) {
 $bytes = random_bytes(16);
 $str = bin2hex($bytes); 
 } else if(function_exists('openssl_random_pseudo_bytes')) {
 $bytes = openssl_random_pseudo_bytes(16);
 $str = bin2hex($bytes); 
 } else if(function_exists('mcrypt_create_iv')) {
 $bytes = mcrypt_create_iv(16, MCRYPT_DEV_URANDOM);
 $str = bin2hex($bytes); 
 } else {
 //Bitte euer_geheim_string durch einen zufälligen String mit >12 Zeichen austauschen
 $str = md5(uniqid('euer_geheimer_string', true));
 } 
 return $str;
}

function dateipfad($typ, $kat){
    switch ($typ) {
    case "pdf":
        $pfad = "files/pdf/".date().$kat;
        break;
    case "image/png":
        $dateityp = "png";        
        break;
    case "image/jpg":
        $dateityp = "jpg";
        break;
}
    return $pfad;
}
function dateityp($arg1){
    switch ($arg1) {
    case "application/pdf":
        $dateityp = "pdf";
        break;
    case "image/png":
        $dateityp = "png";        
        break;
    case "image/jpg":
        $dateityp = "jpg";
        break;
}
    return $dateityp;
}
function create_dokument($funpfad, $funtyp, $funkat, $funbeschreibung, $funkdid, $funkey){
    include 'connect.php';
    $result = $conn->query("SELECT AUTO_INCREMENT FROM information_schema.tables WHERE table_name='tblydokumente' AND table_schema = DATABASE( ) ;");
    $row = $result->fetch_assoc();
    $act_id = $row['AUTO_INCREMENT'];
    $pfad = "files/".$funtyp."/".date("Y-m-d")."-".$funkdid."-".$funkat."-".$act_id.".$funtyp";
    $sql = "INSERT INTO tblydokumente (pfad, dateityp, id_kategorie, beschreibung, id_kunde, cryptkey) VALUES ('".$pfad."', '".$funtyp."', '".$funkat."', '".$funbeschreibung."', '".$funkdid."', '".$funkey."');";
    if ($conn->query($sql) === TRUE) {
        echo "Datenbankeintrag erfolgreich ausgeführt<br><a href='customer_profile.php?id=".$funkdid."'>zurueck</a>";
        move_uploaded_file (
             $_FILES['frmfile']['tmp_name'] ,
             $pfad );
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }    
}



if ( $_FILES['frmfile']['name']  <> "" )
{
    $zugelassenedateitypen = array("image/png", "image/jpeg", "image/gif", "application/pdf");
    if ( ! in_array( $_FILES['frmfile']['type'] , $zugelassenedateitypen ))
    {
        echo "<p>Dateitype ist NICHT zugelassen";
        echo "<pre>";
        echo "FILES:<br>";
        print_r ($_FILES );
        echo "</pre>";
    }
    else
    {          
        create_dokument("files/", dateityp($_FILES['frmfile']['type']), $idkategorie, $beschreibung, $kdid, random_string());
        echo "Hochladen war erfolgreich.<br> ";
    }
}

?>

