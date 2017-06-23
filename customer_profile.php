<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Kundenkartei</title>
  <link rel="stylesheet" type="text/css" href="css/zabcss.css?v=1">
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css?v=1">
  <script src="/jquery/jqBootstrapValidation.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js"></script>
</head>
<body>
<?php
  include 'nav.php';
?>
<!--Layout Anfang-->
<div id="wrap">
<div class="container text-center" id="main">
  <div class="row"> 
    <div class="col-sm-12 col-width">
<!--Anfang Header-->

      <div class="well">
        <table width="100%" border="0">
          <tr>
            <td>
              <h1><b> <span class="glyphicon glyphicon-user"></span> Kundekartei - </b>
              <?php
                include 'connect.php';
                $paramid = $_GET["id"];
                if ($result = $conn->query("SELECT kdnr, anrede, vorname, nachname, geburtsdatum, erstellt, edit FROM viewkunde WHERE kdnr=$paramid;")) {
                  $row=mysqli_fetch_row($result);
                }
                $kdstring = $row[2]." ".$row[3];
                $tempanrede = $row[1];
                echo $kdstring;
              ?>
              </h1>
              <?php
                $erstellt = date_create($row[5]);
                $bearbeitet= date_create($row[6]);
                echo "<i>".date_format($erstellt, 'd.m.Y H:i')."</i> erstellt, <i>".date_format($bearbeitet, 'd.m.Y H:i')." </i>zuletzt geändert</i><br>";
              ?>
            </td>
            <td width="350" style="text-align: right;">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editkunde">Bearbeiten</button>
              <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delkunde">Löschen</button>
            </td>
          </tr>
        </table>
      </div>

<!-- Modal KUNDE LÖSCHEN Anfang-->

<div id="delkunde" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kartei löschen</h4>
      </div>
      <div class="modal-body"> 
        <form class="form-horizontal" action="frm_kunde_del.php" method="post">
          <div class="hidden">
            <label for="frmkdid" class="col-sm-2 control-label">KundenID</label>
            <div class="col-sm-10">
              <?php
              echo "<input class='form-control' name='frmkdid' type='text' value=".$row[0].">";
              ?>
            </div>
          </div>
          <div align="center">
            Wirklich löschen?
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Löschen</button> 
          <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button> 
        </div>
      </form>  
    </div>
  </div>
</div>

<!--Modal Löschen Ende-->      
<!-- MODAL Beabeiten Anfang -->

<div id="editkunde" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Kunde bearbeiten</h4>
      </div>
      <div class="modal-body">

        <?php
          $qry_id;
          $qry_id_anrede;
          $qry_vorname;
          $qry_nachname;
          $qry_geburtsdatum;
          $qry_id_partner;
          $qry_partner_anrede;
          $qry_partner_vorname;
          $qry_partner_nachname;
          $qry_partner_geburtsdatum;
          if ($result = $conn->query("SELECT id, id_anrede, vorname, nachname, geburtsdatum, id_partner FROM tblykunde WHERE id = '".$paramid."'")) {
            while($daten = $result->fetch_object() ){
              $qry_id = $daten->id;
              $qry_id_anrede = $daten->id_anrede;
              $qry_vorname = $daten->vorname;
              $qry_nachname = $daten->nachname;
              $qry_geburtsdatum = $daten->geburtsdatum;      
              $qry_id_partner = $daten->id_partner;
            } 
          } else {
            echo "Error: <br>" . $conn->error;
          }
          
          if ($qry_id_partner != 0 && $result = $conn->query("SELECT id, id_anrede, vorname, nachname, geburtsdatum, id_partner FROM tblykunde WHERE id = '".$qry_id_partner."'")) {
            while($daten = $result->fetch_object() ){
              $qry_partner_anrede = $daten->id_anrede;
              $qry_partner_vorname = $daten->vorname;
              $qry_partner_nachname = $daten->nachname;
              $qry_partner_geburtsdatum = $daten->geburtsdatum;      
            } 
          } else {
            $qry_id_partner = 0;
            $qry_partner_anrede = 1;
            $qry_partner_vorname = "";
            $qry_partner_nachname = "";
            $qry_partner_geburtsdatum = ""; 
          }
          
          $result->close();     
        ?>
        <script>
          $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );
        </script>
        <form class="form-horizontal" method="post" action="frm_profil_update.php">
                <div class="form-group">
          <div class="hidden">
            <label for="frmkdid" class="col-sm-2 control-label">KundenID</label>
            <div class="col-sm-4">
              <?php
              echo "<input class='form-control' name='frmkdid' type='text' value=".$qry_id.">";
              ?>
            </div>
          </div>
        </div> 
        <div class="form-group row"> 
          <label class="control-label col-sm-3" for="idanrede"><div align="left">Anrrede:</div></label>
          <div class="col-sm-9">
            <?php
              echo "<select class='form-control' id='idanrede' name='frmanrede' style='width: 100px;' value='".$qry_id_anrede."'>";
              if ($result = $conn->query("SELECT id, wert FROM tblxanrede")) {
                while($result_row = $result->fetch_object() ){
                  if ($result_row->id == $qry_id_anrede) {
                    echo "<option value=\"".$result_row->id."\" selected>".$result_row->wert."</option> <br>";
                  } else {
                    echo "<option value=\"".$result_row->id."\">".$result_row->wert."</option> <br>";
                  }
                  
                }  
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group row"> 
          <label class="control-label col-sm-3" for="idvorname"><div align="left">Vorname:</div></label>
          <div class="col-sm-9">
            <?php
            echo "<input class='form-control' type='text' id='idvorname' name='frmvorname' value='".$qry_vorname."' style='width: 200px;' required>";
            ?>
          </div>
        </div>      
        <div class="form-group row"> 
          <label class="control-label col-sm-3" for="idnachname"><div align="left">Nachname:</div></label>
          <div class="col-sm-9">
            <?php
            echo "<input class='form-control' type='text' id='idnachnamee' name='frmnachname' value='".$qry_nachname."' style='width: 200px;' required>";
            ?>
          </div>
        </div>
        <div class="form-group row"> 
          <label class="control-label col-sm-3" for="geburtsdatum"><div align="left">Geburtsdatum:</div></label>
          <div class="col-sm-9">
            <div align="left">
              <?php
              echo "<input class='form-control' type='date' id='idgeburtsdatum' name='frmgeburtsdatum' value='".$qry_geburtsdatum."' style='width: 200px;'>";
              ?>
            </div>
          </div>
        </div>
        <div class="form-group row"> 
          <label class="control-label col-sm-3" for="geburtsdatum"><div align="left">mit Partner:</div></label>
          <div class="col-sm-9">
            <div align="left">
              <?php
                if ($qry_id_partner == 0) {
                  echo "<label class='radio-inline'><input type='radio' id='ohne2' name='frmopt' value='ohne' CHECKED>ohne Partner</label>";
                  echo "<label class='radio-inline'><input type='radio' id='mit2' name='frmopt' value='mit'>mit Partner</label>";
                }
                if ($qry_id_partner != 0) {
                  echo "<label class='radio-inline'><input type='radio' id='ohne2' name='frmopt' value='ohne'>ohne Partner</label>";
                  echo "<label class='radio-inline'><input type='radio' id='mit2' name='frmopt' value='mit' CHECKED>mit Partner</label>";
                  echo "<script>
                  $(document).ready(function(){
                  $(\".collapse\").collapse('show');
                  });
                  </script>";
                }
              ?>        
            </div>
          </div>
        </div>





        <div id="partner" class="collapse"> 
          <div class="form-group row">  
          <label class="control-label col-sm-3" for="idanrede2"><div align="left"></div></label>   
            <div class="col-sm-9">  
              <div align="left">
                
                  
              </div>
            </div>
          </div>
          <div class="form-group row"> 
          <label class="control-label col-sm-3" for="idanrede2"><div align="left">Anrede:</div></label>
            <div class="col-sm-9">
            <?php
              echo "<select class='form-control' id='idkanrede2' name='frmanrede2' style='width: 100px;' value='".$qry_partner_anrede."'>";
              if ($result = $conn->query("SELECT id, wert FROM tblxanrede")) {
                while($result_row = $result->fetch_object() ){
                  if ($result_row->id == $qry_partner_anrede) {
                    echo "<option value=\"".$result_row->id."\" selected>".$result_row->wert."</option> <br>";
                  } else {
                    echo "<option value=\"".$result_row->id."\">".$result_row->wert."</option> <br>";
                  }
                }  
              }
            ?>
            </select>
            </div>
          </div>
        <div class="form-group row"> 
          <label class="control-label col-sm-3" for="frmvorname2"><div align="left">Vorname:</div></label>
          <div class="col-sm-9">
            <?php
            echo "<input class='form-control' type='text' id='frmvorname2' name='frmvorname2' value='".$qry_partner_vorname."' style='width: 200px;'>";
            ?>
          </div>
        </div>      
        <div class="form-group row"> 
          <label class="control-label col-sm-3" for="idnachname2"><div align="left">Nachname:</div></label>
          <div class="col-sm-9">
            <?php
            echo "<input class='form-control' type='text' id='idnachname2' name='frmnachname2' value='".$qry_partner_nachname."' style='width: 200px;'>";
            ?>
          </div>
        </div>
        <div class="form-group row"> 
          <label class="control-label col-sm-3" for="geburtsdatum2"><div align="left">Geburtsdatum:</div></label>
          <div class="col-sm-9">
            <div align="left">
              <?php
              echo "<input class='form-control' type='date' id='idgeburtsdatum2' name='frmgeburtsdatum2' value='".$qry_partner_geburtsdatum."' style='width: 200px;'>";
              ?>
            </div>
          </div>
        </div>
        </div>
        <div class="form-group">
          <div class="hidden">
            <label for="frmkdid" class="col-sm-2 control-label">KundenID</label>
            <div class="col-sm-4">
              <?php
              echo "<input class='form-control' name='frmkdid2' type='text' value=".$qry_id_partner.">";
              ?>
            </div>
          </div>
        </div>        
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-success">SPEICHERN</button>
      </div>
    </form>
  </div>
</div>
<script>
$(document).ready(function(){
    $("#mit2").click(function(){
        $(".collapse").collapse('show');
    });
    $("#ohne2").click(function(){
        $(".collapse").collapse('hide');
    });
});

</script>  

<!-- MODAL Ende -->

<!--Ende Header-->
    </div>
  </div>
  <div class="row"> 
  <!--Anfang neue reihe-->
    <div class="col-sm-12">
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-12">
<!--Anfang Details-->

            <div class="well">
              <h3><b><span class="glyphicon glyphicon-pencil"></span> Details</b></h3>
              <table class="table">
              <tbody>
                <tr noborder>
                  <td class="noborder">
                    <b>Kundennummer:</b>
                  </td>
                  <td class="noborder">
                    <?php
                    echo $row[0];
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <b>Name:</b>
                  </td>
                  <td>
                    <?php
                    echo $row[1].' '.$row[2].' '.$row[3];
                    ?>
                  </td>
                </tr>
                <tr>
                  <td>
                    <b>Geburtstag:</b>
                  </td>
                  <td>
                    <?php
                    $date=date_create($row[4]);
                    echo date_format($date,"d.m.y");
                    ?>
                  </td>
                </tr>
              </tbody>
              </table>
            </div>

<!--Ende Details-->
          </div>
          <div class="col-sm-12">
<!--Anfang Status-->

            <div class="well">   
              <h3><b><span class="glyphicon glyphicon-briefcase"></span> Status</b></h3>
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th>Datum</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result = $conn->query("SELECT kdnr, name, status, erstellt FROM viewzab_status WHERE kdnr = ".$paramid." ORDER BY erstellt")) {
                    while($daten = $result->fetch_object() ){
                      $custr = $daten->status." ".$daten->erstellt;
                      echo "<tr><td>".$daten->erstellt."</td><td>".$daten->status."</td></tr>";
                    }
                  }
                  ?>
                </tbody>
              </table>
            </div>

<!--Ende Status-->            
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-12">
<!--Anfang Aufgaben-->

            <div class='well'> 
              <table width="100%">
                <tr>
                  <td>
                    <h3><b><span class="glyphicon glyphicon-tasks"></span> Aufgaben</b></h3>
                  </td>
                  <td style="text-align:right;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modaufgabe">Aufgabe erstellen</button>
                  </td>
                </tr>
              </table>
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th>Aktion</th>
                    <th>Fälligkeit</th>
                    <th>VS</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  include 'connect.php';
                  if ($result = $conn->query("SELECT aktion, ende, vs, id_kunde FROM viewkunde_aufgabe WHERE id_kunde = '".$paramid."' ORDER BY ende;")) {
                    while($daten = $result->fetch_object() ){
                      echo "<tr><td>".$daten->aktion."</td><td>".$daten->ende."</td><td>".$daten->vs."</td></tr>"; 
                    }  
                  }
                  ?>
                </tbody>
              </table>   
            </div>

<!--Ende Aufgaben-->
          </div>
          <div class="col-sm-12">
<!--Anfang Termine-->

            <div class='well'> 
              <table width="100%">
                <tr>
                  <td>
                    <h3><b><span class="glyphicon glyphicon-calendar"></span> Termine</b></h3>
                  </td>
                  <td style="text-align:right;">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modtermin">Termin erstellen</button>
                  </td>
                </tr>
              </table>
              <table class="table table-condensed">
                <thead>
                  <tr>
                    <th>Anlass</th>
                    <th>Datum</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  include 'connect.php';
                  if ($result = $conn->query("SELECT idkd, grund, start, ende FROM viewtermin_kunde WHERE idkd = ".$paramid." ORDER BY start;")) {
                    while($daten = $result->fetch_object() ){
                      echo "<tr><td>".$daten->grund."</td><td>".$daten->start."</td></tr>"; 
                    }  
                  }
                  ?>
                </tbody>
              </table>  
            </div>

<!--Ende Termine-->
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12 col-width">
<!--Dokumente Anfang-->

      <div class='well'>
        <table border="0" width="100%">
          <tr >
            <td>
              <h3><b><span class="glyphicon glyphicon-file"></span> Dokumente</b></h3>
            </td>
            <td style="text-align: right;">
              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#docupload">Dokument hochladen</button>
            </td>
          </tr>
        </table>
        <br>
        <table class="table table-condensed">
          <thead>
            <tr>
              <th>Sparte</th>
              <th>Kategorie</th>
              <th>Datum</th>
              <th>Beschreibung</th>
              <th>Link</th>
            </tr>
          </thead>
          <tbody>
            <?php
            function get_path($cryptkey) {
                
            }


            if ($result = $conn->query("SELECT pfad, idkategorie, kategorie, idsparte, sparte, erstellt, kdid, beschreibung, cryptkey FROM viewkunde_dokument WHERE kdid = ".$paramid." ORDER BY idsparte")) {
              while($daten = $result->fetch_object() ){
              echo "<tr><td>".$daten->sparte."</td><td>".$daten->kategorie."</td><td>".$daten->erstellt."</td><td>".$daten->beschreibung."</td><td><a href='file.php?ci=".$daten->cryptkey."'>öffnen</a></td></tr>";
              }
              }
            ?>      
          </tbody>
        </table>
      </div>

<!--Dokumente Ende-->
    </div>
  </div>
</div>
</div>

<!--Layout Ende-->
<!--Include Footer-->

<?php 
include 'bot.php';
?>

<!-- MODAL TERMIN Anfang -->
<div id="modtermin" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Termin erstellen</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="frm_termin_erstellen.php">
        <div class="form-group">
          <label for="selvorlage" class="control-label col-sm-2">Anlass:</label>
          <div class="col-sm-10">           
            <select class="form-control" id="selvorlage" name="frmvorlage">
              <?php
              include 'connect.php';
              $abfrage = "SELECT tblxterminvorlagen.id    AS id_vorlage,
              tblxterminvorlagen.wert  AS beschreibung,
              tblxterminvorlagen.start AS start,
              tblxterminvorlagen.ende  AS ende
              FROM zabv1.tblxterminvorlagen tblxterminvorlagen";
              if ($result = $conn->query($abfrage)) {
                while($daten = $result->fetch_object() ){
                  echo "<option value=".$daten->id_vorlage.">".$daten->beschreibung."</option>";
                }
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group">
          <label for="frmdatum" class="col-sm-2 control-label">Datum:</label>
          <div class="col-sm-4">
            <input class='form-control' name='frmdatum' type='date'>
          </div>
        </div>
        <div class="form-group">
          <div class="hidden">
            <?php
              echo "<input class='form-control' name='frmkdid' type='text' value='".$paramid."'>";
            ?>
          </div>
        </div>           
        <div class="form-group">
          <label for="frmkdid" class="col-sm-2 control-label">Erinnerung:  </label>
          <div class="col-sm-4">
            <p align="left">
            <label class="radio-inline"><input type="radio" name="frmopt" value="Ja">Ja</label>
            <label class="radio-inline"><input type="radio" name="frmopt" value="Nein" CHECKED>Nein</label>
            </p>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
        <button type="submit" name="submit" class="btn btn-success">Speichern</button>
      </div>
      </form>
    </div>
  </div>
</div>
<!-- MODAL TERMIN Ende -->
<!-- MODAL DATEI UPLOAD Anfang -->
<div id="docupload" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Dokument hochladen</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="frm_upload_file.php" enctype="multipart/form-data">
        <div class="form-group">  
          <label class="control-label col-sm-2" for="frmkategorie">Kategorie:</label>
          <div class="col-sm-10">
            <select class="form-control" name="frmkategorie">
              <?php
              if ($result = $conn->query("SELECT idkat, kategorie, sparte, idsparte FROM viewdokument_kategorie ORDER BY idsparte, idkat;")) {
                while($daten = $result->fetch_object() ){
                  echo "<option value='".$daten->idkat."'>(".$daten->sparte.") - ".$daten->kategorie."</option> <br>"; 
                }  
              }
              ?>
            </select>
          </div>
        </div>         
        <div class="form-group">
          <label class="control-label col-sm-2">Datei:</label>
          <div class="col-sm-10">
            <input name="frmfile" type="file" class="file" data-show-preview="false">
          </div>
        </div>
        <div class="form-group">
          <div class="hidden">
            <label for="frmkdid" class="col-sm-2 control-label">KundenID</label>
            <div class="col-sm-10">
              <?php
              echo "<input class='form-control' name='frmkdid' type='text' value=".$row[0].">";
              ?>
            </div>
          </div>
          <div class="form-group">
            <label for="frmbeschreibung" class="col-sm-2 control-label">Bemerkung</label>
            <div class="col-sm-8">
              <input class='form-control' name='frmbeschreibung' type='text'>
            </div>
          </div>
        </div>        
      </div>
      <div class="modal-footer">
        <button type="submit" name="submit" class="btn btn-success">Hochladen</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Abbrechen</button>
      </div>
    </form>
  </div>
</div>  
<!-- MODAL Ende -->




</body>
</html>