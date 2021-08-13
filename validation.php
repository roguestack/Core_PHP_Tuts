<?php 
$unameerr=$fnameerr=$lnameerr=$passerr=$cpasserr=$emailerr=$gendererr=$uploaderr=$checkboxerr=" ";
$username=$first_name=$last_name=$password=$cpassword=$email=$gender=" ";
//print_R($_POST);

if($_SERVER["REQUEST_METHOD"]=="POST"){
    
    if(empty($_POST['username'])){
        $unameerr = "Username can't be empty";
    }
    else{
        $validUserName=test_input($_POST['username']);
        if(!preg_match("/^[a-zA-Z0-9]{8,}+$/",$validUserName)){
            $unameerr="Minimum 8 characters wit h Combination of Uppercase/Lowercase Letters & Digits are allowed";}
    }

    if(empty($_POST['firstname'])){
        $fnameerr = "First name is required";
    }else{
        $validFirstName=test_input($_POST['firstname']);
        if(!preg_match("/^[a-zA-Z-' ]*$/",$validFirstName)){
                $fnameerr="Only Letters & Whitespace are allowed";}
    }
    
    if(empty($_POST['lastname'])){
        $lnameerr = "Last name is required";
    }else{
        $validLastName=test_input($_POST['lastname']);
        if(!preg_match("/^[a-zA-Z-' ]*$/",$validLastName)){
            $lnameerr="Only Letters & Whitespace is allowed";
        }
    }
    
    if(empty($_POST['password'])){
        $passerr = "password is required";
    }
    // else{
    //      if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[~!^(){}<>%@#&*+=_-])[^\s$`,.\/\\;:|]{4,40}$/',$_POST['password'])){
    //         $passerr = "Minimum  Characters, One Uppercase letter, One Lowercase Letter required";
    //       }
    // }
    if(empty($_POST['cpassword'])){
        $cpasserr = "Please reconfirm the password";
    }else{
         $validpass=$_POST['password'];
         $validrePass=$_POST['cpassword'];

         if($validpass!=$validrePass){
            $cpasserr = "Passwords are not matching";
          }
    }
    
    if (empty($_POST['email'])){
        $emailerr="Email is required";   
    }    
    else{
        $validEmail=test_input($_POST['email']);
        if (!filter_var($validEmail, FILTER_VALIDATE_EMAIL)) {
            $emailerr = "Invalid email format";
        }
    }
    $validGender=test_input($_POST['gender']);
}    

if(isset($_POST['submit'])){
        $upload_dir="uploads/";
        $img_dir=$_FILES['fileupload']['tmp_name'];
        $img_file=$upload_dir.basename($_FILES['fileupload']['name']);
        $img_size=$_FILES['fileupload']['size'];
        
        if(!empty($img_file)){
            $img_ext=pathinfo($img_file,PATHINFO_EXTENSION);
            $validExt=array("jpg","jpeg","png","gif");

            if($img_size>3000000){
                $uploaderr= "Upload Failed, File size should be less than 3MB";
            
            }elseif(!$img_ext=="jpg" && !$img_ext=="jpeg" && !$img_ext=="png"){
                $uploaderr= "Upload Failed, Only .jpg,.jpeg or .png extensions are allowed";

            }else{
                move_uploaded_file($img_dir,$img_file);
                $image=basename( $_FILES["fileupload"]["name"],$img_ext); // used to store the filename in a variable
                //echo $image;
            }
        }
        else{
            $uploaderr= "upload fail";
        }
        if(empty($checkbox)){
            $checkboxerr= "checkbox not ticked";
        }
}
function test_input($data){
    $data=trim($data);
    $data=stripslashes($data);
    $data=htmlspecialchars($data);
    return $data;
}

?>