<?php

// try {
//     $conn = new PDO('mysql:host=localhost; dbname=users;charset=utf8', 'root', 'root'); 
//         $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
//     echo "Connection successful:";
// } catch (PDOException $e) {
//     echo "<p>Unable to Connect (database): " . $e->getMessage() . "</p>";
// }


if(isset($_POST['submit'])){
    validate();
  
}

function validate(){

    try {
        $conn = new PDO('mysql:host=localhost; dbname=users;charset=utf8', 'root', 'root'); 
            $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
        echo "Connection successful:";
    } catch (PDOException $e) {
        echo "<p>Unable to Connect (database): " . $e->getMessage() . "</p>";
    }
    
    $upload_dir="uploads/";
    $img_dir=$_FILES['fileupload']['tmp_name'];
    $img_file=$upload_dir.basename($_FILES['fileupload']['name']);
    $img_size=$_FILES['fileupload']['size'];

    $img_ext=pathinfo($img_file,PATHINFO_EXTENSION);
    $validExt=array("jpg","jpeg","png","gif");

    // print_r($img_dir)."<br>";
    // echo "<br>";
    // print_r($img_file)."<br>";
    //  echo "<br>";
    // print_r($img_file)."<br>";
    // echo "<br>";
    // print_r($img_size)."<br>";
    // echo "<br>";
    // print_r($img_ext)."<br>";

    if(!empty($img_ext)){
        if($img_size>3000000){
            $uploaderr= "Upload Failed, File size should be less than 3MB";
        }elseif(!in_array($img_ext,$validExt)){
            $uploaderr= "Upload Failed, Only .jpg,.jpeg or .png extensions are allowed";
        }else{
            move_uploaded_file($img_dir,$img_file);
            $image=basename($_FILES["fileupload"]["name"],$img_file); // used to store the filename in a variable
            echo "<br>";
            print_r($image);
            // echo $image."<br>";
            }
        }
    else{
        $uploaderr= "upload fail";
    }

    try {
        echo "<br>";
        print_r($image);
        $img=$image;
    
        $sql = "INSERT INTO img (img_name) VALUES ('$img')";
    
        print_r($sql);
   
        if ($conn->query($sql)) {
            echo "New Record Inserted Successfully')";
        }
        else{
            echo "New Record Inserted failed')";
        }
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
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
    <form action="" onclick="validate()" method="POST" enctype="multipart/form-data">   
        <h1>Sign up</h1>
        
<label for="">Profile Pic : </label>
        <input class="form-control" type="file" name="fileupload" id="fileupload"> <span class="error"><?php echo $uploaderr ?></span>
        <br>

        <input type="submit" value="Submit" name="submit">
        <br>
        <br>
    </form>


</div>

</body>
</html>