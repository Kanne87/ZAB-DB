<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Dashboard</title>
  <link rel="stylesheet" href="zabcss.css?v=1" media="screen"/>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css?v=1" />  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
include 'nav.php';
?>

<!--Layout Anfang-->

<div class="container text-center">
  <div class="row"> 
    <div class="col-sm-12 col-width">
<!--Anfang Header-->

      <div class="well">
        <h1><b>Dashboard </b>
      </div>

<!--Ende Header-->
    </div>
  </div>
  <div class="row"> 
  <!--Anfang neue reihe-->
    <div class="col-sm-12 col-width">
<!--Dokumente Anfang-->
      <div class='well'>
        <table border="0">
          <tr>
            <td>
              <img src="img/ico_status.png">&nbsp;&nbsp;&nbsp;
            </td>
            <td>
              <h2>Status</h2>
            </td>
          </tr>
        </table>            
        <table class="table">
          <thead>
            <tr>
              <th width="140">Kundennummer</th>
              <th width="200">Name</th>
              <th width="200">Status</th>
            </tr>
          </thead>
          <tbody>   
            <?php
            include 'connect.php';
            if ($result = $conn->query("SELECT kdnr, name, status FROM viewzab_status ORDER BY status")) {
              while($daten = $result->fetch_object() ){
                echo "<tr><td>".$daten->kdnr."</td><td>".$daten->name."</td><td>".$daten->status."</td></tr>";
              }
            }
            ?>    
          </tbody>
        </table>
      </div>

<!--Dokumente Ende-->
    </div>
  </div>
  <div class="row"> 
  <!--Anfang neue reihe-->
    <div class="col-sm-12 col-width">
<!--Aufgaben Anfang-->

      <div class='well'>
        <table border="0">
          <tr>
            <td>
              <img src="img/ico_aufgabe.png" width="75%">
            </td>
            <td>
              <h2>Aufgaben</h2>
            </td>
          </tr>
        </table>           
        <table class="table">
          <thead>
            <tr>
              <th width="140">Name</th>
              <th width="200">Aktion</th>
              <th width="200">Kategorie</th>
              <th width="200">Zeitraum</th>
              <th width="200">VsNr/Gesellschaft</th>
            </tr>
          </thead>
          <tbody>   
            <?php
            if ($result = $conn->query("SELECT idaufgabe, aktion, kategorie, start, ende, gesellschaft, vsnr, name FROM viewaufgaben_dashboard ORDER BY ende")) {
              while($daten = $result->fetch_object() ){
                echo "<tr><td>".$daten->name."</td><td>".$daten->aktion."</td><td>".$daten->kategorie."</td><td>".$daten->start."-".$daten->ende."</td><td>".$daten->vsnr." (".$daten->gesellschaft.")</td></tr>";
              }
            }
            ?>    
          </tbody>
        </table>
      </div>

<!--Aufgaben Ende-->
    </div>
  </div>
<div class="row"> 
  <!--Anfang neue reihe-->
    <div class="col-sm-12 col-width">
<!--Termine Anfang-->

      <div class='well'>
        <table border="0">
          <tr>
            <td>
              <img src="img/ico_termin.png">&nbsp;&nbsp;&nbsp;
            </td>
            <td>
              <h2>Termine</h2>
            </td>
          </tr>
        </table>  
        <table class="table">
          <thead>
            <tr>
              <th width="140">Name</th>
              <th width="200">Grund</th>
              <th width="200">Beginn</th>
              <th width="200">Ende</th>
              <th width="200">Erinnerung</th>
            </tr>
          </thead>
          <tbody>   
            <?php
            if ($result = $conn->query("SELECT id_termin, kunde, grund, start, ende, erinnerung FROM viewtermin_kunde ORDER BY start")) {
              while($daten = $result->fetch_object() ){
                echo "<tr><td>".$daten->kunde."</td><td>".$daten->grund."</td><td>".$daten->start."</td><td>".$daten->ende."</td><td>".$daten->erinnerung."</td></tr>";
              }
            }
            ?>    
          </tbody>
        </table>
      </div>

<!--Termine Ende-->
    </div>
  </div>
</div>

<!--Layout Ende-->



<?php 
include 'bot.php';
$result->close();
?>
</body>
</html>