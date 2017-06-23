<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Bericht Import</title>
  <link rel="stylesheet" href="css/zabcss.css?v=1" media="screen"/>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.css?v=1" />  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="/bootstrap/js/bootstrap.js"></script>
</head>
<body>
<?php 
require_once 'nav.php';
error_reporting(E_ALL);

$valid_formats = array("htm", "html");
$max_file_size = 1024*100;
$path = "files/";
$count = 0;
$report_files;

function get_lines($url) {
    $atts = array();
    libxml_use_internal_errors(true);
    $xml = new DOMDocument("1.0", "ISO-8859-15"); 
    $xml->loadHTMLFile($url);
    foreach ($xml->getElementsByTagName('div') as $link) {
        $value_array = parse_value($link->GetAttribute('style'));
        $pos_top = strpos($link->GetAttribute('style'), 'top');
        $atts[] = array('text' => $link->nodeValue, 'linie' => $link->GetLineNo(), 'top' => $value_array['top'], 'left' => $value_array['left']);
    }
    return $atts;
}

function parse_value($str) {
    $pos_top = strpos($str, 'top:');
    $pos_left = strpos($str, 'left:');
    $value_top = substr($str, $pos_top+4, $pos_left - $pos_top-5);
    $value_left = substr($str, $pos_left+5, 4);
    $return_array = array('top' => $value_top, 'left' => $value_left);
    return $return_array;
}

function SearchForId($searchval, $keystring, $array) {
    foreach ($array as $key => $val) {
        if ($val[$keystring] === $searchval) {
            return $key;
        }
    }
    return null;
}

function SearchForText($top, $left, $array) {
    foreach ($array as $key => $val) {
        if ($val['top'] === $top && $val['left'] === $left) {
            return $array[$key]['text'];
        }
    }
    return null;
}

function GetCustomer($report) {    //noch nicht fertig..
    if(get_page_topic($report) == 1) {
        return SearchForText("371", "130", $report);
    }
    if(get_page_topic($report) == 2) {
        return SearchForText("61", "70", $report);
    }
    if(get_page_topic($report) == 3) {
        return SearchForText("61", "70", $report);
    }
    if(get_page_topic($report) == 4) {
        return SearchForText("61", "70", $report);
    }  
    if(get_page_topic($report) == 5) {
        return SearchForText("61", "70", $report);
    } 
}

function PrintLines($lines) {
    $output;
    $i = 0;
    $z = count($lines) - 1;
    echo "<font size='8'><table width='100%'>";
    while($i<=$z) {
        echo "<tr><td width='90'>Zeile: ".$lines[$i]['linie']."<td><td width='80'>Top: ".$lines[$i]['top']."</td><td width='80'>Left: ".$lines[$i]['left']."</td><td>Text: ".$lines[$i]['text']." </td></tr>";
        $i++;    
    }
    echo "</tr></table></font>";
}

function SortArray($array_input) {
    foreach ($array_input as $key => $row) {
    $top[$key]    = $row['top'];
    $left[$key] = $row['left'];
    }
    array_multisort($top, SORT_ASC, $left, SORT_ASC, $array_input);
    return $array_input;
}

function get_page_topic($report) {
    $topic_id = 0;
    if(SearchForId('Ihr Berater', 'text', $report) != 0) {
        $topic_id = 1;
    }
    if(SearchForId('Persönliche Daten', 'text', $report) != 0 && SearchForId('Angaben zur Person', 'text', $report) != 0) {
        $topic_id = 2;
    }
    if(SearchForId('Bestand heute', 'text', $report) != 0) {
        $topic_id = 3;
    }
    if(SearchForId('Alterseinkünfte', 'text', $report) != 0 && SearchForId('Bedarf', 'text', $report) != 0) {
        $topic_id = 4;
    }
    if(SearchForId('Bedarf', 'text', $report) != 0 && SearchForId('Vermögen heute', 'text', $report) != 0) {
        $topic_id = 5;
    }
    return $topic_id;
}

if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
	foreach ($_FILES['reports']['name'] as $f => $name) {     
	  if ($_FILES['reports']['error'][$f] == 4) {
	    continue; // Skip file if any error found
	  }	       
	  if ($_FILES['reports']['error'][$f] == 0) {	           
      if ($_FILES['reports']['size'][$f] > $max_file_size) {
	      $message[] = "$name is too large!.";
	      continue; // Skip large files
	    }
			elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
				$message[] = "$name is not a valid format";
				continue; // Skip invalid file formats
			}
			elseif(preg_match("/pg_0/i", $name  ) == 0) {
				$message[] = "$name is not a report";
				continue; // Skip useless reports
			}
	    else{ // No error found! Move uploaded files 
	      if(move_uploaded_file($_FILES["reports"]["tmp_name"][$f], $path.$name)) {
          $report_files[] = $path.$name;
          global $count; // Number of successfully uploaded file
          $count++;
        }
	    }
	  }
	}
}

function SortText($unsortiert) {
    foreach($unsortiert AS $report) {
        $sortiert = (SortArray(get_lines($report)));
    }
    return $sortiert;
}


function CreateArray($array) {
    $oarray = SortText($array);
    foreach($oarray AS $report) {
        print_r($report);
        echo "<br>";
    }
}

function OutputExtract($report_files) {
  global $count;
  echo "es gibt ".$count." Dateien<br><br>";
  echo "------------------------------<br><br>"; 
  foreach($report_files AS $report) {
    $lines = (SortArray(get_lines($report)));
    // Hier das Array erweitern
    echo "Dateiname: ".$report."<br>";
    echo "Topic-ID: ".get_page_topic($lines)."<br>";
    echo "***<br>";
    echo "Name: ".GetCustomer($lines);
    echo "<br>***<br>";
    PrintLines($lines);
    echo "<br>===============<br><br>"; 
  }
  return $lines;
}

?>

<!--Layout Anfang-->
<div class="container text-center" id="main">
  <div class="row"> 
    <div class="col-sm-12 col-width">
<!--Anfang Header-->
      <div class="well">
        <h1><b>BERICHT IMPORT</b></h1>
      </div>
<!--Ende Header-->
    </div>
  </div>
  <div class="row"> 
    <div class="col-sm-12" align="center"> 
    <a href="#extract" data-toggle="collapse">Extrakt zeigen</a><br><br>
      <div class="well">
        
        <?php
            echo "Details<br>";
            echo CreateArray($report_files);
        ?>
      </div>
      <div id="extract" class="collapse">
        <div class="well">
          <?php
            echo OutputExtract($report_files);
            //print_r(OutputArray($report_files));
          ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php 
include 'bot.php';
?>
</body>
</html>