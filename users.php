<?php
include_once "db_config.php";

session_start();

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
    <title>Users</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css"/>
</head>
<body class="bg-info">
<?php
if($_SESSION['name']){
    ?>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-10 bg-light rounded my-2 py-2">
                <h1 class="text-center text-dark pt-2">Users List</h1>
                <hr>
                <div class="container-fluid" style="display:inline-block;">
                    <input type="text" style="size:20px;border-radius:10px;"id="search_text" name="search" placeholder="Search..">
                    <?php if(isset($_SESSION['name'])){ ?>
                        <span style="font-size:30px;postion: relative;width:100px;margin:0px;padding:0px;"> Welcome, <?php echo $_SESSION['fname'] ?> </span>
                    <?php } ?>
                    <a style="postion:relative;float:right;" href="logout.php" class="btn btn-primary">Log Out</a>
                </div>
                <hr>

                <table id="tableData" class="text-center table table-bordered table-striped table-hover">
                    <thead>
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
                        <?php
                            $sql=$conn->query("SELECT user_list.*,countries.cname,states.sname,cities.ctname FROM user_list LEFT JOIN countries ON user_list.ctry = countries.id LEFT JOIN states ON user_list.st = states.id LEFT JOIN cities on user_list.cty = cities.id ORDER BY user_id DESC");
                            $sql->setFetchMode(PDO::FETCH_ASSOC);
                            while($row=$sql->fetch()){
                        ?>
                        <tr>
                        <td><?php echo $row['user_id']?></td>
                        <td><?php echo $row['user_name']?></td>
                        <td><?php echo $row['fname']?></td>
                        <td><?php echo $row['lname']?></td>
                        <td><?php echo $row['eml']?></td>
                        <td><?php echo $row['gnd']?></td>
                        <td><?php echo $row['cname']?></td>
                        <td><?php echo $row['sname'] ?></td>
                        <td><?php echo $row['ctname']?></td>
                        <td><img height=50px width=50px src="uploads/<?php echo htmlspecialchars($row['img'])?>"></td>
                        <!-- <td><img style="height:50px;width:50px;" src="uploads/<?php echo htmlspecialchars($row['img'])?>"></td> -->
                        <td><a href="edit.php?user_id=<?php echo $row['user_id']?>" id='edit' class="btn btn-primary">Edit</a></td>
                        <td><a href="remove.php?user_id=<?php echo $row['user_id']?>" id='remove' class="btn btn-danger">Delete</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php
}else{
    header ("Location:login.php");
}
?>
<link type="text/css" rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
<script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
<script>
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

// $(document).ready(function(){
//     $('#tableData').DataTable();
        
// });

 </script>
</body>
</html>