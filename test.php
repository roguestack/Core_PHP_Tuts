<?php 

$unameerr=" ";
$username=" ";

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    if(empty($_POST['username'])){
        $unameerr = "Username can't be empty";
    }else{
        $validUserName=test_input($_POST['username']);
        if(!preg_match("/^[a-zA-Z0-9]{8,}+$/",$validUserName)){
            $unameerr="Only Combination of Uppercase/Lowercase Letters, Digits are allowed";
        }
        else{
            $unameerr="username accepted";
        }
    }
}
function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Sign up Form</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid">
    <form action="" method="POST" enctype="multipart/form-data">   

        <label for="">Username</label><span class="error"> * <?php echo $unameerr ?></span>
        <input type="text" class="form-control" name="username" id="username">
        <br>

        <input type="submit" value="Submit" name="submit">
        <br>
        <br>
    </form>
</div>


</body>
</html>