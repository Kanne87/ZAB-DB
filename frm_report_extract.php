<?php
require_once 'connect.php';


$files =  $_FILES['reports'];
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
    while($i<=$z) {
        echo 'Text: '.$lines[$i]['text'].' # Linie: '.$lines[$i]['linie'].' #  Left: '.$lines[$i]['left'].' # Top: '.$lines[$i]['top'].'<br>';
        $i++;    
    }
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
                    $count++; // Number of successfully uploaded file
                }
	        }
	    }
	}
}


echo "es gibt ".$count." Dateien<br>";
foreach($report_files AS $report) {
    $cut_path;
    echo $report;
    echo "<br><br>";
    $lines = (SortArray(get_lines($report)));
    echo "<br><br>";
    echo "Topic: ".get_page_topic($lines);
    echo "<br>***<br>";
    echo GetCustomer($lines);
    echo "<br>***<br>";
    PrintLines($lines);
    echo "<br>===============<br>";
}






// pdf2html.exe C:\pdfcmd\files\ist.pdf C:\xampp\htdocs\extract\ordner\









?>