<?php 

include 'db_config.php';

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

session_start();

$user_id=$_GET['user_id'];
    
//echo $user_id;
if(isset($_GET['user_id'])){
    $sql=$conn->query("SELECT user_list.*,countries.cname,states.sname,cities.ctname FROM user_list LEFT JOIN countries ON user_list.ctry = countries.id LEFT JOIN states ON user_list.st = states.id LEFT JOIN cities on user_list.cty = cities.id WHERE user_id='$user_id'");
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    $row=$sql->fetch();
 
}

if(isset($_POST['submit'])){
    $err=0;
    if(empty($_POST['username'])){
            echo "inside username";
            $unameerr = "Username can't be empty";
            $err++;
    }
    else{
        $validUserName=test_input($_POST['username']);
            if(!preg_match("/^[a-zA-Z0-9]{8,}+$/",$validUserName)){
            $unameerr="Minimum 8 characters wit h Combination of Uppercase/Lowercase Letters & Digits are allowed";
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

    if(empty($_POST['checkbox'])){
        $checkboxerr= "checkbox not ticked";
        $err++;
    }
        
    $upload_dir="uploads/";
    $img_dir=$_FILES['newUpload']['tmp_name'];
    $img_file=$upload_dir.basename($_FILES['newUpload']['name']);
    $img_size=$_FILES['newUpload']['size'];
    $img_ext=pathinfo($img_file,PATHINFO_EXTENSION);
    //$validExt=array("jpg","jpeg","png","gif");

    if(!empty($img_ext)){
        if($img_size>3000000){
            $uploaderr= "Upload Failed, File size should be less than 3MB";
            $err++;
    }elseif(!$img_ext=="jpg" && !$img_ext=="jpeg" && !$img_ext=="png"){
        $uploaderr= "Upload Failed, Only .jpg,.jpeg or .png extensions are allowed";
        $err++;
    }else{
        move_uploaded_file($img_dir,$img_file);
        $image=basename($_FILES["newUpload"]["name"],$img_file); // used to store the filename in a variable
        //echo $image."<br>";
    }
    }
    if(empty($image)){
        $image=$_POST['fileupload'];
    }
    // print_r($image);
    // exit;

echo $err;
print_r($err);        
if($err==0){
    try {
        $user_id=$_POST['user_id'];        
        $uname=$_POST['username'];
        $fname=$_POST['firstname'];
        $lname=$_POST['lastname'];
        $eml=$_POST['email'];
        $gnd=$_POST['gender'];
        $ctry=$_POST['country'];
        $st=$_POST['state'];
        $cty=$_POST['city'];
        $img=$image;

        $sql ="UPDATE user_list SET user_name='$uname',fname='$fname', lname='$lname',eml='$eml',gnd='$gnd',ctry='$ctry',st='$st',cty='$cty',img='$image' WHERE user_id='$user_id'";
    
    // print_r($user_id);
     print_r($sql);
    if ($conn->query($sql)) {
         //print_r($sql);
         Header ("Location:pagination-2.php");
    }
    else{
        echo "Operation failed";
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

$result= $conn->query("SELECT * FROM countries");
$result = $result->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css"  >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Edit User Details</title>
    
</head>
<body>
    <?php
if($_SESSION['name']){
    ?>
<div class="container" style="max-width:700px">
    <form class="form-control" id="signup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" onclick="validate()" method="POST" enctype="multipart/form-data">   
        <h1 class="text-center">Edit Users</h1>     
        <span class="error">*required field</span><br>
        <br>
        <input type="hidden" name='user_id' value="<?php echo $_GET['user_id']?>">
        
        <div class="form-floating">
            <input type="text" class="form-control" name="username" id="username" value="<?php echo $row['user_name'] ?>">
            <span class="error">* <?php echo $unameerr;?></span>
            <label for="username">Username</label>
        </div>
        <div class="form-floating">
            <input type="text" class="form-control" name="firstname" id="firstname" value="<?php echo $row['fname'] ?>">
            <label for="firstname">First Name</label>
            <span class="error"> * <?php echo $fnameerr;?></span>
        </div>
        <div class="form-floating">
            <input class="form-control" type="text" name="lastname" id="lastname" value="<?php echo $row['lname'] ?>">
            <label for="lastname">Last Name</label>    
            <span class="error"> *<?php echo $lnameerr ?></span>
        </div>
        
        <div class="form-floating">
            <input class="form-control" type="email" name="email" id="email" value="<?php echo $row['eml'] ?>">
            <label for="email">E-mail</label>
            <span class="error"> *<?php echo $emailerr ?></span>
        </div>
        
        <div class="form-control">
                <label for="">Gender</label>
                
            <div class="form-check">
                <label class="form-check-label" for="gendermale">Male</label>
                <input class="form-check-input" id="gendermale" type="radio" name="gender" value="Male" <?php if ($row['gnd']=="Male") echo "checked"; ?> /> 
            </div>
            <div class="form-check">
                <label class="form-check-label" for="genderfemale">Female</label>
                <input class="form-check-input" type="radio" id="genderfemale" name="gender" value="female" <?php if ($row['gnd']=="female") echo "checked"; ?>> 
            </div>
            <span class="error">* <?php echo $gendererr ?></span> 
        </div>
        
        <br>
        <div class="mb-3">
        <label for="country-dropdown">Country:</label>
        <select name="country" id="country-dropdown" class="form-control"> 
              <?php foreach($result as $res){ ?>
              <option value="<?= $res['id'] ?>"<?=($row['ctry'] == $res['id'] ? 'selected="selected"':'')?>><?php echo $res['cname'] ?></option>
              <?php } ?>
        </select>
        </div>
        
        <div class="mb-3">
            <label for="state">State:</label>
            <select name="state" id="state-dropdown" class="form-control">
                <?php foreach($result as $res){ ?>
                <option value="<?=$res['id'] ?>"<?=($row['sname']== $res['id']?'selected="selected"':'') ?>><?php echo $res['sname'] ?></option>
                <?php } ?>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="city">City:</label>
                <select name="city" id="city-dropdown" class="form-control">
                <?php foreach($result as $res){ ?>
                    <option value="<?= $res['id']?>"<?= ($row['ctyname']== $res['id']?'selected=="selected"':'')?>> <?php echo $res['ctname'] ?></option>
                <?php } ?>
            </select>
        </div>
        
        <input type="hidden" name='fileupload' value="<?php echo $row['img']?>">
        <div class="mb-3">
        <label class="form-label" for="">Profile Pic </label>
            <div class="container" style="display: flex;">
                <img height=70px width=70px src="uploads/<?php echo htmlspecialchars($row['img'])?>">
                <input name="newUpload" class="form-control" style="height: 38px !important;margin-left: 20px !important;margin-top: 10px !important;" type="file" name="fileupload" id="fileupload"> <span class="error"><?php echo $uploaderr ?></span>
            </div>
        </div>
        
        <input type="checkbox" name="checkbox" id="checkbox" > &nbsp I agree with terms & Conditions 
        <span class="error"><?php echo $checkboxerr ?></span> <br>
        <br>

        <input type="submit" value="Update" name="submit" class="btn btn-success">
        
        <br>
        <br>
    </form>
</div>
<?php
}else{
    header ("Location:login.php");
}
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
    $('#country-dropdown').on('change', function() {
    var country_id = this.value;
    $.ajax({
            url: "states.php",
            type: "POST",
        data: {
            country_id: country_id
        },
// cache: false,
success: function(result){
$("#state-dropdown").html(result);
$('#city-dropdown').html('<option value="">Select State First</option>'); 
}
});
});    
$('#state-dropdown').on('change', function() {
    var state_id = this.value;
    $.ajax({
    url: "cities.php",
    type: "POST",
    data: {
    state_id: state_id
},
//cache: false,
success: function(result){
    console.log(result)
$("#city-dropdown").html(result);
}
});
});
});
</script>

</body>
</html>