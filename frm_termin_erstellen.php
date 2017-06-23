<?php
    $vorlage = $_POST["frmvorlage"];
    $datum = $_POST["frmdatum"];
    $kdid = $_POST["frmkdid"];
    $erinnerung = ($_POST['frmopt'] == 'Ja')? '1':'0';
    7
    $sqlqry = "INSERT INTO tblytermin (id_kunde, start, grund, erinnerung) VALUES ('".$kdid."', '".$datum."', '".$vorlage."', '".$erinnerung."')";
    include 'connect.php';
    if ($result = $conn->query($sqlqry)) {
        
            echo "jop";
        
    } else {
            echo "Error: " . $sqlqry . "<br>" . $conn->error;
        }
?>