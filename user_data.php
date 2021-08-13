<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

include_once 'db_config.php';

try{
    //$sql=$conn->query("SELECT `user_id`, `user_name`, `fname`, `lname`, `eml`, `gnd`, `ctry`, `st`, `cty`,`img` FROM `user_list`");
    $sql=$conn->query("SELECT user_list.*,countries.cname,states.sname,cities.ctname FROM user_list LEFT JOIN countries ON user_list.ctry = countries.id LEFT JOIN states ON user_list.st = states.id LEFT JOIN cities on user_list.cty = cities.id ORDER BY user_id DESC");
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    
}catch(PDOException $e){
    die("Couldn't get Data from Database");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"/>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>User Details</title>
</head>
<body>

<div class="container">
    <input type='hidden' id='sort' value='asc'>
    <div class="row justify-content-center">
        <div class="col-md-10 bg-light mt-2 rounded">
            <h1 class="text-center">User Details</h1>
            <hr>
            <input type="text" style="border-radius:10px;" id="search_text" name="search" placeholder="Search..">
        </div>
    </div>
    <hr>
    <table id="tableData" class="table table-bordered text-center">
        <thead style="background-color:#20639B;color:white;border-radius:10px">
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
        <tbody>
            <tr>
                <?php while($row=$sql->fetch()):?>
                <td><?php echo $row['user_id']?></td>
                <td><?php echo $row['user_name']?></td>
                <td><?php echo $row['fname']?></td>
                <td><?php echo $row['lname']?></td>
                <td><?php echo $row['eml']?></td>
                <td><?php echo $row['gnd']?></td>
                <td><?php echo $row['cname']?></td>
                <td><?php echo $row['sname'] ?></td>
                <td><?php echo $row['ctname']?></td>
                <td><?php echo $row['img']?></td>
                <td><input type="button" value="Edit" class="btn btn-primary"></td>
                <td><input type="button" value="Delete" class="btn btn-danger"></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
        </table>
</div>   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#search_text").keyup(function(){
        var search=$(this).val();
        $.ajax({
            url:'fetch.php',
            method:'POST',
            data:{query:search},
            success:function(response){
                $("#tableData").html(response);
            }
        })
    });
});

});  
 </script>
</body>
</html>

