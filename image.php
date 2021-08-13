<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

try {
    $conn = new PDO('mysql:host=localhost; dbname=users;charset=utf8', 'root', 'root'); 
        $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); 
 
     echo "Connection successful";
    // echo "<br>";
    
} catch (PDOException $e) {
    echo "<p>Unable to Connect (database): " . $e->getMessage() . "</p>";
}

if(isset($_POST['submit'])){
    echo "inside submit";
    $img_dir=$_FILES['fileupload']['tmp_name'];
    $img_file=$upload_dir.basename($_FILES['fileupload']['name']);
    $img_size=$_FILES['fileupload']['size'];

    $upload_dir="uploads/";
    $img_ext=strtolower(pathinfo($img_file,PATHINFO_EXTENSION));
    $validExt=array("jpg","jpeg","png","gif");

    $image=basename($_FILES["fileupload"]["name"],$img_file); 
    move_uploaded_file($img_dir,$img_file);
    
    $sql=$conn->query("INSERT INTO img (:img_name) VALUES ('$img_file')");
    $sql->bindParam(':img_name',$img_file);    
    
    
    if($conn->query($sql)){
        echo "Image uploaded successfull";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Document</title>
</head>
<div class="container-fluid" style="max-width:700px">
    <div class="mb-3">
    <form class="form-control" method="POST" enctype="multipart/form-data">
        <label class="form-label" for="">Profile Pic </label>
        <input class="form-control" type="file" name="fileupload" accept="*/image">
        <input type="submit" name="submit" value="Upload" class="btn btn-primary">
    </form>
    </div>
</div>
<body>
    
</body>
</html>