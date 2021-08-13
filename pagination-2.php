<?php
include_once 'db_config.php';

session_start();

if(!isset($_SESSION['id'])){
    header("location:login.php");
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Pagination-2</title>
    <style>
    body{
        background: url("cool-background.png");
        background-repeat: no-repeat;
        background-position:center;
        background-size:cover;
        height:100%;
        width:100%;
    }
    form{
        opacity:0.9;
        border-radius:20px;
    }
    </style>

</head>
<body> 

<div class="container-fluid">
        <div class="row justify-content-center" style="margin-top:20px;max-width:100%;">
            <div class="col-lg-10 bg-light rounded">
                <h2 class="text-center text-dark pt-2 display-3">Users List</h2>
                <hr>
                <div class="container-fluid" style="display:inline-block;">
                    <span style="font-size:30px;postion: relative;width:100px;margin:0px;padding:0px;"> Welcome, <?php echo $_SESSION['name'] ?> </span>
                    <a style="posItion:relative;float:right;" href="logout.php" class="btn btn-primary">Log Out</a>
                </div>
                <hr>
            </div>
            <div class="col-lg-10 bg-light rounded">
                <table id="example" class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>User name</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email </th>
                            <th>Gender</th>
                            <th>Country</th>
                            <th>State</th>
                            <th>City</th>
                            <th>Profile Pic</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table> 
            </div>
        </div>
</div>


<script>
$(document).ready(function() {
    $('#example').DataTable( {
        //"processing": true,
        "serverSide": true,
        "searching":true,
        "order":[],
        "ajax": {
            'url':"pagi.php",
            'method':"POST",
        },
            "columns": [
                {"name": "user_id"},
                {"name": "user_name"},
                {"name": "fname"},
                {"name": "lname"},
                {"name": "eml"},
                {"name": "gnd"},
                {"name": "ctry"},
                {"name": "st"},
                {"name": "cty"},
                {"name": "img"},
                {"name":"Action"}
            ]
    });
    
});
</script>
</body>
</html>
