<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/zabcss.css?v=1" media="screen"/>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css?v=1" />  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
include 'nav.php';
?>

<!--Layout Anfang-->
<div class="container text-center" id="main">
  <div class="row"> 
    <div class="col-sm-12 col-width">
<!--Anfang Header-->

      <div class="well">
        <table width="100%">
          <tr>
            <td>
              <h1><b>Kunden</b></h1>
            </td>
            <td style="text-align:right;">
              <a href="customer_add.php" class="btn btn-success" role="button">Neu</a>
            </td>
          </tr>
        </table>
      </div>

<!--Ende Header-->
    </div>
  </div>
  <div class="row"> 
  <!--Anfang neue reihe-->
    <div class="col-sm-12 col-width">
<!--Kundenliste Anfang-->

        <div class="list-group list-width">
          <?php
          include 'connect.php';
          if ($result = $conn->query("SELECT kdnr, anrede, vorname, nachname FROM viewkunde ORDER BY nachname")) {
            while($daten = $result->fetch_object() ){
              $link = "/customer_profile.php?id=".$daten->kdnr;
              $custr = $daten->anrede." ".$daten->vorname." ".$daten->nachname;
              echo "<a href=\"" .$link. "\" class=\"list-group-item\">".$custr."</a>";
            }
          }
          $result->close();
          ?>
        </div>


<!--Kundenliste Ende-->
    </div>
  </div>
</div>


<!--Layout Ende-->



<?php 
include 'bot.php';
?>
</body>
</html>