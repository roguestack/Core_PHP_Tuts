<?php

include_once 'db_config.php';

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ERROR);

//$searchInput=$_GET['search-by-column'];

$start = $_POST['start'];
$end = $_POST['length'];
$strInput=$_POST['search']['value'];
$columnIndex=$_POST['order'][0]['column'];
$columnSortOrder=$_POST['order'][0]['dir'];

// error_reporting(E_ALL);
// ini_set('display_errors', TRUE);
// ini_set('display_startup_errors', TRUE);

$qstr = '';
if(isset($columnIndex)){
    $colum = $_POST['columns'][$columnIndex]['name'];
    $qstr = ' ORDER BY '.$colum.' '.$columnSortOrder; 
}
// echo "SELECT * FROM user_list WHERE (user_name LIKE '%$strInput%' OR fname LIKE '%$strInput%' OR lname LIKE '%$strInput%') ORDER BY $colum LIMIT $start,$end";
$sql = $conn->query("SELECT user_list.*,countries.cname,states.sname,cities.ctname FROM user_list LEFT JOIN countries ON user_list.ctry = countries.id LEFT JOIN states ON user_list.st = states.id LEFT JOIN cities on user_list.cty = cities.id WHERE (user_name LIKE '%$strInput%' OR fname LIKE '%$strInput%' OR lname LIKE '%$strInput%') $qstr LIMIT $start,$end");  
// print_r ($sql);
$sql->setFetchMode(PDO::FETCH_ASSOC);
$data = array();
while($row = $sql->fetch()){ 
    $data[] = array(
            $row['user_id'],
            $row['user_name'],
            $row['fname'],
            $row['lname'],
            $row['eml'],
            $row['gnd'],
            $row['cname'],
            $row['sname'],
            $row['ctname'],
            "<img height=70px width=70px src=uploads/".htmlspecialchars($row['img']).">",
            "<a href='edit.php?user_id=". $row["user_id"] ."' id='edit' class='btn btn-primary'>Edit </a>".
            "<a href='remove.php?user_id=". $row["user_id"] ."' id='delete' class='btn btn-danger'>Delete</a>"
	);
};
$sql1 = $conn->query("SELECT * FROM user_list");  
$sql1->setFetchMode(PDO::FETCH_ASSOC);
//$page_result = $sql;  
$total_records = $sql1->rowCount(); 

$output  = array(
    'draw' => $_POST['draw'],
    'recordsTotal' => $total_records,
    'recordsFiltered' => $total_records,
    'data' => $data,
);
echo json_encode($output);
?>  

