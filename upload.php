<?php

if(isset($_POST['submit'])){
    $upload_dir="uploads/";
    $img_dir=$_FILES['fileupload']['tmp_name'];
    $img_file=$upload_dir.basename($_FILES['fileupload']['name']);
    $img_size=$_FILES['fileupload']['size'];

    if(!empty($img_file)){
        $img_ext=pathinfo($img_file,PATHINFO_EXTENSION);
        $validExt=array("jpg","jpeg","png","gif");

        if($img_size>3000000){
            echo "File size should be less than 3MB";
        
        }elseif(!in_array($img_ext,$validExt)){
            echo "Only .jpg, .jpeg or .png extensions are allowed";
        
        }else{
           
            move_uploaded_file($img_dir,$img_file);
            echo "Uploading Done";
        }
    }
    else{
        echo "upload fail";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="upload.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="fileupload" id="fileupload">
        <input type="submit" value="Upload" name="submit">
    </form>
</body>
</html>