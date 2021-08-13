<?php
include_once 'db_config.php';

session_start();
if(isset($_SESSION['id'])){
    header("location:pagination-2.php");
}

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

if (isset($_SESSION['register']) && ($_SESSION['register']==true)){
    echo "<h1>Registered</h1>";
    unset($_SESSION['register']);
}

if($_POST['register']){
    header("location:new_signup.php");
}
$message="";
if($_POST>0){
    if(isset($_POST['submit'])){
        $username=stripcslashes($_POST['username']);
        $pass=stripcslashes($_POST['password']);
        $rpss=(sha1($pass));
        
        if (empty($_POST['username']) && empty($_POST['password'])){
            $unameerr="username can't be blank";
            $pserr="password can't be blank";
        }elseif(empty($_POST['username'])){
            $unameerr="username can't be blank";
        }elseif(empty($_POST['password'])){
            $pserr="password can't be blank";
        }else{
            $query="SELECT * FROM user_list WHERE user_name='$username'
            AND pss='".$rpss."'";

            $q = $conn->query($query);
            $row = $q->fetch();
            if($row > 0) {
                echo "Login Successful";
                $_SESSION['id']=$row['user_id'];
                $_SESSION['name']=$row['user_name'];
                header("location:pagination-2.php");
                //$_SESSION['id']=1;              
            }else{
               $logerr= "Login Failed";
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="style.css" type="text/css" >
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<title>Login</title>
<style>
    body{
        background-image: url("cool-background.png");
        background-position:center;
        background-size:cover;
        background-repeat: no-repeat;
        
    }
    form{
        opacity:0.9;
        border-radius:20px;
    }
</style>
</head>
<body>
<div class="container" style="max-width:500px;position:relative;margin-top:300px;">
    <form class="form-control" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">   
        <h1 class="text-center">Login</h1> 
        <span style="font-size:20px;" class="error"><?php echo $logerr ?></span>
            <div class="mb-2">
           <input type="text" class="form-control" name="username" id="username" placeholder="Username">
           <span class="error"><?php echo $unameerr ?></span>
        </div>
        <div class="mb-2">
            <input class="form-control" type="password" name="password" id="password" placeholder="Password" >
            <span class="error"><?php echo $pserr ?></span>
        </div>
        <div class="mb-5">
            <input style="position:relative; float:left;" type="submit" value="Submit" name="submit" class="btn btn-success">    
            <!-- <input style="position:relative; float:right;" type="submit" value="Register" name="register" class="btn btn-primary">     -->
        </div>
    </form>
    <br>
    
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>