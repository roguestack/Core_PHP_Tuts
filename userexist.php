<?php

include_once 'db_config.php';

if(isset($_POST['username_check'])){
    $username=$_POST['username'];
    $sql=$conn->query("SELECT * from user_list where user_name='$username'");
    if($sql->rowCount()>0){
        echo "exist";
    }
}

?>