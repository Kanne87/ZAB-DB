<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>

  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>index.php</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="zabcss.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container-fluid text-center">
  <div class="row content">
<?php
  include 'nav.php';
  include 'connect.php';
  $paramid = $_GET["id"];
if ($result = $conn->query("SELECT kdnr, anrede, vorname, nachname, geburtsdatum FROM viewkunde;")) {
 $result->data_seek($paramid-1);
 $row = $result->fetch_row();
  }
 $kdstring = "<h3>".$row[2]." ".$row[3]."</h3>";
echo $kdstring;
?>
<br><br>

<form action="select.html">
  <label>
    <select name="szenarien" size="5" >

<?php
include 'connect.php';
if ($result = $conn->query("SELECT id, kdnr, create_date, modify_date, status FROM viewparametershort WHERE kdnr = $paramid;")) {
 while($daten = $result->fetch_object() ){
 $str = $daten->id." ".$daten->create_date;
         echo '<option value="">'.$str.'</option>';
  }
  }
?>
    </select>
  </label><br>
  <input type="submit" value="Bearbeiten">
  <a href="frmparameter"><input type="button" value="Neu"></a>
</form>


</div>
</body>
</html>