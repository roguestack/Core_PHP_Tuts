<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

include_once 'db_config.php';

$output = '';  
if(isset($_POST['query'])){
     $search=$_POST['query'];
    $sql=$conn->query("SELECT user_list.*,countries.cname,states.sname,cities.ctname FROM user_list LEFT JOIN countries ON user_list.ctry = countries.id LEFT JOIN states ON user_list.st = states.id LEFT JOIN cities on user_list.cty = cities.id WHERE user_name LIKE '%".$search."%' ORDER BY user_id DESC");
     //print_r($sql);
     //$sql->bind_param("ss",$search);
 }else{
         $sql=$conn->query("SELECT * FROM user_list ORDER BY user_id ASC");
 }
$sql->setFetchMode(PDO::FETCH_ASSOC);
$row=$sql;
if($row>0){
    $output="<thead style='background-color:#20639B;color:white;border-radius:10px;'>
    <tr>
        <th>User Id</th>
        <th>User Name</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Gender</th>
        <th>Country</th>
        <th>State</th>
        <th>City</th>
        <th>Profile Pic</th>    
        <th>Action</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>";
    while($row=$sql->fetch()) {
    $output.= 
    "<tr>
            <td>".$row['user_id']."</td>
            <td>".$row['user_name']."</td>
            <td>".$row['fname']."</td>
            <td>".$row['lname']."</td>
            <td>".$row['eml']."</td>
            <td>".$row['gnd']."</td>
            <td>".$row['cname']."</td>
            <td>".$row['sname']."</td>
            <td>".$row['ctname']."</td>
            <td><img height=50px width=50px src='uploads/".$row['img']."'></td>
            <td><a href='edit.php?user_id=".$row['user_id']."' id='edit' class='btn btn-primary'>Edit</a></td>
            <td><a href='remove.php?user_id=".$row['user_id']."?>' id='remove' class='btn btn-danger'>Delete</a></td>
        </tr>";
    }
    $output.="</tbody>";
    echo $output;
}else{
    echo "<h3>No record found</h3>";
}
?>