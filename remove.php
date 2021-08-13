<?php

include_once "db_config.php";

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ERROR);

if(isset($_GET['user_id'])){
    $user_id=$_GET['user_id'];
    //   echo "inside update";
//     // validate();
//     // if($err==0){
    try {
        $sql ="DELETE FROM user_list WHERE user_id='$user_id'";
//         print_r($user_id);
//         print_r($sql);
        if ($conn->query($sql)) {
            //echo "hi"; die;
            Header ("Location:pagination-2.php");
        }
        else{
            echo "No Record Found";
        }
    } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
    }
}

 ?>
// <!DOCTYPE html>
// <html lang="en">
// <head>
//     <meta charset="UTF-8">
//     <meta http-equiv="X-UA-Compatible" content="IE=edge">
//     <meta name="viewport" content="width=device-width, initial-scale=1.0">
//     <title>Remove User</title>
// </head>
// <body>
<!-- //     <input type="hidden" name='user_id' value="<?php echo $_GET['user_id'] ?>" > -->
// </body>
// </html>