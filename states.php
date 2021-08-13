<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');


include_once "db_config.php";

$country_id = $_POST["country_id"];
$result = $conn->query("SELECT id,sname FROM states WHERE country_id = $country_id");
$result = $result->fetchAll();
$html="<option value=''>Select State</option>";
//print_r($result);

foreach($result as $res){ 
  $html .= "<option value='".$res['id']."'>" .$res['sname']."</option>";
} 
echo $html;

?>
