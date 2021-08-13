<?php
include_once 'db_config.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);
session_start();
$unameerr=$fnameerr=$lnameerr=$passerr=$cpasserr=$emailerr=$gendererr=$uploaderr=$checkboxerr=" ";
$username=$first_name=$last_name=$password=$cpassword=$email=$gender=" ";

$result= $conn->query("SELECT * FROM countries");
$result = $result->fetchAll();

if(isset($_POST['submit'])){
    if(empty($_POST['username'])){
        //echo "inside username";
        $unameerr = "Username can't be empty";
        $err++;
    }
    else{
        $validUserName=test_input($_POST['username']);
        if(!preg_match("/^[a-zA-Z0-9]{5,}+$/",$validUserName)){
            $unameerr="Minimum 5 characters with Combination of Uppercase/Lowercase Letters & Digits are allowed";
            $err++;
        }
    }           
    if(empty($_POST['firstname'])){
        $fnameerr = "First name is required";
        $err++;
    }else{
        $validFirstName=test_input($_POST['firstname']);
        if(!preg_match("/^[a-zA-Z-' ]*$/",$validFirstName)){
        $fnameerr="Only Letters & Whitespace are allowed";
        $err++;
        }
    }
    if(empty($_POST['lastname'])){
        $lnameerr = "Last name is required";
        $err++;
    }else{
    $validLastName=test_input($_POST['lastname']);
    if(!preg_match("/^[a-zA-Z-' ]*$/",$validLastName)){
        $lnameerr="Only Letters & Whitespace is allowed";
        $err++;
       }
    }
    
    if(empty($_POST['password'])){
        $passerr = "password is required";
        $err++;
    }else{
        $enc=sha1(($_POST['password']));
    }
    // else{
    //      if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!^(){}<>%@#&*+=_-])[^\s$`,.\/\\;:|]{4,40}$/',$_POST['password'])){
    //         $passerr = "Minimum  Characters, One Upperlnameerrcase letter, One Lowercase Letter required";
    //       }
    
    if(empty($_POST['cpassword'])){
        $cpasserr = "Please reconfirm the password";
        $err++;
    }else{
        $validpass=$_POST['password'];
        $validrePass=$_POST['cpassword'];
        if($validpass!=$validrePass){
        $cpasserr = "Passwords are not matching";
        $err++;
        }

    }
    if (empty($_POST['email'])){
        $emailerr="Email is required";   
        $err++;
    }    
    else{
        $validEmail=test_input($_POST['email']);
        if (!filter_var($validEmail, FILTER_VALIDATE_EMAIL)) {
            $emailerr = "Invalid email format";
            $err++;
        }
    }
    if(empty($_POST['gender'])){
        $gendererr="Select Gender";
        $err++;
    }else{
        $validGender=test_input($_POST['gender']);
    }

    $upload_dir="uploads/";
    $img_dir=$_FILES['fileupload']['tmp_name'];
    $img_file=$upload_dir.basename($_FILES['fileupload']['name']);
    $img_size=$_FILES['fileupload']['size'];
    $img_ext=pathinfo($img_file,PATHINFO_EXTENSION);

    if(!empty($img_ext)){
        if($img_size>3000000){
        $uploaderr= "Upload Failed, File size should be less than 3MB";

    }elseif(!$img_ext=="jpg" && !$img_ext=="jpeg" && !$img_ext=="png"){
        $uploaderr= "Upload Failed, Only .jpg,.jpeg or .png extensions are allowed";

    }else{
        move_uploaded_file($img_dir,$img_file);
        $image=basename($_FILES["fileupload"]["name"],$img_file); // used to store the filename in a variable
        //echo $image."<br>";
        }
    }
    else{
        $uploaderr= "upload fail";
    }


if($err==0){
    $enc=sha1(($_POST['password']));

    try {
        $uname=$_POST['username'];
        $fname=$_POST['firstname'];
        $lname=$_POST['lastname'];
        $pss=$enc;
        $eml=$_POST['email'];
        $gnd=$_POST['gender'];
        $ctry=$_POST['country'];
        $st=$_POST['state'];
        $cty=$_POST['city'];
        $img=$image;

        $sql = "INSERT INTO user_list (user_name,fname, lname, pss,eml,gnd,ctry,st,cty,img)
        VALUES ('$uname','$fname', '$lname', '$pss','$eml','$gnd','$ctry','$st','$cty','$img')";
        
        if ($conn->query($sql)) {
        $_SESSION['register'] = true;
        header("location:login.php");
        }else{
            echo "User Registration Failed";
        }
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
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
    <title>New User Registration</title>
    <script defer type="text/javascript" src="validation.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" i>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
    body{
        background-image: url("cool-background.png");
        background-repeat: no-repeat;
        background-position:center;
        background-size:cover;
    }
    form{
        opacity:0.9;
        border-radius:20px;
    }
    form .error {
        color: #ff0000;
    }
    </style>
</head>
<body>
<div class="container" style="margin:20px 0px 20px 25%;max-width:50%;">
    <form class="form form-control" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" id="registration" enctype="multipart/form-data">
    <div class="mb-3">
        <h3 class="text-center display-4">User Registration</h3>
        <span class="error">*required field</span>
        <br>
        <br>
        <label class="form-label" for="username"> User Name</label>
        <span class="error">* <?php echo $unameerr;?></span>
        <input class="form-control" type="text" name="username" id="username" />
    </div>
    <div class="mb-3">
        <label class="form-label" for="firstname">First Name</label>
        <span class="error"> * <?php echo $fnameerr;?></span>
        <input class="form-control" type="text" name="firstname" id="firstname" placeholder="John"/>
    </div>
    <div class="mb-3">
        <label class="form-label" for="lastname">Last Name</label>
        <span class="error"> *<?php echo $lnameerr ?></span>
        <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Doe"/>
    </div>
    <div class="mb-3">
        <label class="form-label" for="email">Email</label>
        <span class="error"> *<?php echo $emailerr ?></span>
        <input class="form-control" type="email" name="email" id="email" placeholder="john@doe.com"/>
    </div>
    <div class="mb-3">
        <label class="form-label" for="password">Password</label>
        <span class="error"> *<?php echo $passerr ?></span>
        <input class="form-control" type="password" name="password" id="password" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"/>
    </div>
    <div class="mb-3">
        <label class="form-label" for="cpassword">Reconfirm Password</label>
        <span class="error"> * <?php echo $cpasserr ?></span>
        <input class="form-control" type="password" name="cpassword" id="cpassword" placeholder="&#9679;&#9679;&#9679;&#9679;&#9679;"/>
    </div>
    <div class="form-control mb-2">
            <label for="">Gender</label>
            <span class="error">* <?php echo $gendererr ?></span> 
            <div class="form-check">
                <label class="form-check-label" for="gendermale">Male</label>
                <input class="form-check-input" id="gendermale" type="radio" name="gender" value="Male" > 
            </div>
            <div class="form-check">
                <label class="form-check-label" for="genderfemale">Female</label>
                <input class="form-check-input" type="radio" id="genderfemale" name="gender" value="female" > 
            </div>
            
    </div>
    
    <div class="mb-3">
        <label class="form-label" for="country-dropdown">Country</label>
        <select class="form-control" name="country" id="country-dropdown">
              <option value="">Select Country </option>
              <?php foreach ($result as $res){ ?>
              <option value="<?= $res["id"] ?>"><?php echo $res['cname'] ?></option>
              <?php } ?>
            </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="state-dropdown">State</label>
        <select class="form-control" name="state" id="state-dropdown">
              <option value=""> Select State </option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label" for="city-dropdown">City</label>
        <select class="form-control" name="city" id="city-dropdown">
            <option value="">Select City</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label" for="profilePic">Profile Pic</label>
        <input class="form-control" type="file" name="fileupload" id="fileupload">
    </div>

    <div class="mb-3">
        <input type="checkbox" name="checkbox" id="checkbox" > I agree with terms & Conditions
        <span class="error"><?php echo $checkboxerr ?></span> <br>
    </div>
    
    <div class="mb-3">
        <button class="btn btn-primary" name="submit" id="submit" type="submit">Register</button>
    </div>
    </form>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    
<script>
$(document).ready(function(){
    $('#country-dropdown').on('change',function(){
        var country_id = this.value;
        console.log(country_id);
        $.ajax({
            url:"states.php",
            type:"POST",
            data:{'country_id':country_id },
        success:function(result){
            $('#state-dropdown').html(result);
            $('#city-dropdown').html('<option class="form-control" value="">Select State First</option>');
        }
    });
    });
        $('#state-dropdown').on('change',function(){
            var state_id = this.value;
            $.ajax({
                url:"cities.php",
                type:"POST",
                data:{
                    state_id:state_id
                },
            success:function(result){
                $('#city-dropdown').html(result);
            }
        });
        });
});

</script>

</body>
</html>