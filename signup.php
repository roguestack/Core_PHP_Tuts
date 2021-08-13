
<?php 

include 'db_config.php';
// echo "hi";
// exit;
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

    $unameerr=$fnameerr=$lnameerr=$passerr=$cpasserr=$emailerr=$gendererr=$uploaderr=$checkboxerr=" ";
    $username=$first_name=$last_name=$password=$cpassword=$email=$gender=" ";

$err=0;
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
    $validExt=array("jpg","jpeg","png","gif");
    
    if(!empty($img_ext)){
        if($img_size>3000000){
            $uploaderr= "Upload Failed, File size should be less than 3MB";
            $err++;
        }elseif(!$img_ext=="jpg" && !$img_ext=="jpeg" && !$img_ext=="png"){
            $uploaderr= "Upload Failed, Only .jpg,.jpeg or .png extensions are allowed";
            $err++;
        }else{
            move_uploaded_file($img_dir,$img_file);
            $image=basename($_FILES["fileupload"]["name"],$img_file); // used to store the filename in a variable
            //echo $image."<br>";
            }
        }
        else{
            $uploaderr= "upload fail";
            $err++;
        }
        if(empty($_POST['checkbox'])){
           $checkboxerr= "checkbox not ticked";
           $err++;
        }

if($err==0){
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
            
            echo "<h1 class='text-center;color:blue;'>User Registered Successfully </h1>";
            sleep(2);
            header("refresh:5; login.php" );
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
$result= $conn->query("SELECT * FROM countries");
$result = $result->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Sign up Form</title>
    
</head>
<body>
<div class="container" style="max-width:700px">
    <form class="form-control" id="signup" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" enctype="multipart/form-data">   
        <h1 class="text-center">User Registration Form</h1>     
        <!-- <h2 class="text-center" id="message">User Registered Successfully</h2> -->
        <span class="error">*required field</span><br>
        <br>
        <div class="form-floating">
            <input type="text" class="form-control" name="username" id="username" placeholder="Username">
            <span class="error">* <?php echo $unameerr;?></span>
            <label for="username">Username</label>
        </div>
        
        <div class="form-floating">
            <input type="text" class="form-control" name="firstname" id="firstname" placeholder="First Name">
            <label for="firstname">First Name</label>
            <span class="error"> * <?php echo $fnameerr;?></span>
        </div>
        <div class="form-floating">
            <input class="form-control" type="text" name="lastname" id="lastname" placeholder="Last Name" >
            <label for="lastname">Last Name</label>    
            <span class="error"> *<?php echo $lnameerr ?></span>
        </div>
        <div class="form-floating">
            <input class="form-control" type="password" name="password" id="password" placeholder="Password" >
            <label for="password">Password</label>
            <span class="error"> *<?php echo $passerr ?></span>
        </div>
        <div class="form-floating">
            <input class="form-control" type="password" name="cpassword" id="cpassword" placeholder="Reconfirm Password">
            <label for="cpassword">Confirm Password</label>
            <span class="error"> * <?php echo $cpasserr ?></span>
        </div>
        <div class="form-floating">
            <input class="form-control" type="email" name="email" id="email" placeholder="example@example.com">
            <label for="email">E-mail</label>
            <span class="error"> *<?php echo $emailerr ?></span>
        </div>
        
        <div class="form-control">
                <label for="">Gender</label>
                
            <div class="form-check">
                <label class="form-check-label" for="gendermale">Male</label>
                <input class="form-check-input" id="gendermale" type="radio" name="gender" value="Male" > 
            </div>
            <div class="form-check">
                <label class="form-check-label" for="genderfemale">Female</label>
                <input class="form-check-input" type="radio" id="genderfemale" name="gender" value="female" > 
            </div>
            <span class="error">* <?php echo $gendererr ?></span> 
        </div>
        
        <br><br>
        <div class="mb-3">
        <label for="country-dropdown">Country:</label>
        <select name="country" id="country-dropdown" class="form-control">
              <option value=""> Select Country </option>
              <?php foreach($result as $res){ ?>
              <option value=" <?= $res['id'] ?>"><?php echo $res['cname'] ?>  </option>
              <?php }  ?>
        </select>
        </div>
       
        <div class="mb-3">
            <label for="state">State:</label>
            <select name="state" id="state-dropdown" class="form-control">
                <option value=" ">Select State</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label for="city">City:</label>
                <select name="city" id="city-dropdown" class="form-control">
                <option value=" "> Select City</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label class="form-label" for="">Profile Pic </label>
            <input class="form-control" type="file" name="fileupload" id="fileupload"> <span class="error"><?php echo $uploaderr ?></span>
        </div>
        

        <input type="checkbox" name="checkbox" id="checkbox" > &nbsp I agree with terms & Conditions 
        <span class="error"><?php echo $checkboxerr ?></span> <br>
        <br>
        
        <input type="submit" value="Submit" name="submit" id="submit" class="btn btn-success">
        <input type="reset" value="Reset" name="reset"class="btn btn-secondary">
        <br>
        <br>
    </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
$(document).ready(function() {
$("#username").on('blur',function(){
var userInput=$('#username').val();
    $.ajax({
        url:'userexist.php',
        method:'POST',
        data:{
            'username_check':1,
            'username':userInput,
        },
        success:function(response){
            if(response == 'exist'){
                $('#username').siblings("span").text('Username Already Exist..');
                $('#signup :input').prop("disabled",true);
            }
        }
    });
});

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
    //    console.log(result)
$("#city-dropdown").html(result);
}
});
});
});

</script>

</body>
</html>