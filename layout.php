<div class="container text-center">
  <div class="row"> 
    <div class="col-sm-12">
      <div class="well">
        <!--<div class="panel-body">-->
          <table width="100%" border="0">
            <tr>
              <td>
                <h1><b>Kundekartei - </b>
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
        <!--</div>-->
      </div>
    </div>
  </div>
  <div class="row"> 
  <!--Anfang neue reihe-->
    <div class="col-sm-12">
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-12">
            Kundendetails
          </div>
          <div class="col-sm-12">
            Status
          </div>
        </div>
      </div>
      <div class="col-sm-6">
        <div class="row">
          <div class="col-sm-12">
            Aufgaben
          </div>
          <div class="col-sm-12">
            Termine
          </div>
        </div>
      </div>
    </div>
  </div>ende reihe
  <div class="row">
    footer
  </div>
</div>