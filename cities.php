<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

include_once "db_config.php";

$state_id = $_POST["state_id"];
$result = $conn->query("SELECT id,ctname FROM cities WHERE state_id = $state_id");
$result = $result->fetchAll();
$html="<option value=''>Select City</option>";
//print_r($result);

 foreach($result as $res){ 
   $html .= "<option value='".$res['id'] ."'>" .$res['ctname'] . "</option>";
 }  
echo $html;
?>