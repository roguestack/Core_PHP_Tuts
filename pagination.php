<?php

include_once 'db_config.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

$limit = 10;  // Number of entries to show in a page.
    // Look for a GET variable page if not found default is 1.     
if (isset($_GET["page"])) { 
    $pn  = $_GET["page"]; 
} 
else { 
    $pn=1; 
};  
$start_from = ($pn-1) * $limit;  
$sql = $conn->query("SELECT * FROM user_list LIMIT $start_from, $limit");  
$sql->setFetchMode(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"/>
    <title>Pagination</title>
</head>
<body>
<div class="container">
    <table class="text-center table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <td>User Id</td>
                <td>User Name</td>
                <td>First Name</td>
                <td>Last Name</td>
                <td>E-mail</td>
                <td>Gender</td>
                <td>Country</td>
                <td>State</td>
                <td>City</td>
                <td>Profile Pic</td>
            </tr>
        </thead>
        <tbody>
        <?php 
        while ($row=$sql->fetch()) { ?>
        <tr>
            <td><?php echo $row['user_id']?></td>
            <td><?php echo $row['user_name']?></td>
            <td><?php echo $row['fname']?></td>
            <td><?php echo $row['lname']?></td>
            <td><?php echo $row['eml']?></td>
            <td><?php echo $row['gnd']?></td>
            <td><?php echo $row['ctry']?></td>
            <td><?php echo $row['st']?></td>
            <td><?php echo $row['cty']?></td>
            <td><img height=70px width=70px src="uploads/<?php echo htmlspecialchars($row['img'])?>">></td>
        </tr>
            </tbody>
        <?php } ?>
    </table>
    
    <nav style="float:right;">
        <ul class="pagination justify-content-center">
            <?php
                $sql = $conn->query("SELECT count(*) FROM user_list")->fetchColumn();
                //print_r($sql);
                $total_records=$sql;

                // Number of pages required.
                $total_pages = ceil($total_records / $limit);  

                $pagLink = "";                        
                for ($i=1; $i<=$total_pages; $i++) {

                if ($i==$pn) {
                    $pagLink .= "<li class='page-item'><a href='pagination.php?page=".$i."'> ".$i." </a></li>";
                }            
                else  {
                    $pagLink .= "<li style='list-style:none;display:inline;'><a href='pagination.php?page=".$i."'> ".$i." </a></li>";  
                }
                };  
                echo $pagLink;  
            ?>
        </ul>
    </nav>  
    </div>
</body>
</html>