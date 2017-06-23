<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Analyse</title>
  <link rel="stylesheet" href="css/zabcss.css?v=1" media="screen"/>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css?v=1" />  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<?php 
include 'nav.php';
?>
<!--Layout Anfang-->
<div class="container text-center" id="main">
  <div class="well">
    <div class="row"> 
      <div class="col-sm-8">
<!--Anfang Header--> 
        <h1><b>Analysen</b></h1>
      </div>
      <div class="col-sm-4" style="padding-top: 16px;">
        <div align="right">
          <button type="button" class="btn-sm btn-success" data-toggle="modal" data-target="#report_import">IMPORT</button>
          <div id="report_import" class="modal fade" role="dialog" align="center">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">AVP Import</h4>
                </div>
                <div class="modal-body" align="left">
                  <form action="analyse_import.php" method="post" enctype="multipart/form-data" id="js-upload-form">               
                    <input id="input-file" name="reports[]" type="file" accept="text/html/*" multiple webkitdirectory />
                      <div id="errorBlock" class="help-block"></div> <br/>
                    <input type="submit" value="Hochladen" name="submit">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">ABBRECHEN</button>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
<!--Ende Header-->
  </div>
  <div class="row"> 
    <div class="well">
      da
    </div>
  </div>
</div>
<?php 
include 'bot.php';
?>
</body>
</html>