<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>index.php</title>
  <link rel="stylesheet" href="css/zabcss.css?v=1" media="screen"/>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<?php
  include 'nav.php';
?>


<div class="container text-center">
  <div class="row"> 
    <div class="col-sm-12 col-width">
<!--Anfang Header-->

      <div class="well">
        <h1><b>Kunde erstellen </b>
      </div>
    </div>
  </div>
  <div class="row"> 
    <div class="col-sm-6 col-width">
      <div class="well">
        <table width="80%" align="center">
          <tr>
            <td>
              <form method="post" action="frm_add_customer.php">
              Anrede:<br>
              <select name="frmanrede">
              <?php
              include 'connect.php';
              if ($result = $conn->query("SELECT id, wert FROM tblxanrede")) {
                while($daten = $result->fetch_object() ){
                      echo "<option value=\"".$daten->id."\">".$daten->wert."</option> <br>";
                }
                  $result->close();
              }
              ?>
              </select><br><br>
              Vorname:<br>
              <input type="text" name="frmvorname">    <br><br>
              Nachname:<br>
              <input type="text" name="frmnachname">   <br><br>
              Geburtsdatum:<br>
              <input type="date" name="frmgeburtsdatum">   <br><br>
              <div class="radio-inline">
              <label><input type="radio" id="ohne" name="optradio" checked>ohne Partner</label>
              </div>
              <div class="radio-inline">
                <label><input type="radio" id="mit" name="optradio">mit Partner</label>
              </div><br>
              <div id="partner" class="collapse">
                Anrede:<br>
                <select name="frmanrede2">
                <?php
                include 'connect.php';
                if ($result = $conn->query("SELECT id, wert FROM tblxanrede")) {
                  while($daten = $result->fetch_object() ){
                        echo "<option value=\"".$daten->id."\">".$daten->wert."</option> <br>";
                  }
                    $result->close();
                }
                ?>
                </select><br><br>
                Vorname:<br>
                <input type="text" name="frmvorname2">    <br><br>
                Nachname:<br>
                <input type="text" name="frmnachname2">   <br><br>
                Geburtsdatum:<br>
                <input type="date" name="frmgeburtsdatum2">   <br><br>


              </div>
              <script>
              $(document).ready(function(){
                  $("#mit").click(function(){
                      $(".collapse").collapse('show');
                  });
                  $("#ohne").click(function(){
                      $(".collapse").collapse('hide');
                  });
              });
              </script>
              <br>
              <input type="submit" value="Submit">   <br><br>
              </select><br><br>
              </form>
              
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
<?php 
include 'bot.php';
?>
</body>
</html>