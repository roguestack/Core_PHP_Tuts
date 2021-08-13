<?php

include_once 'db_config.php';

if(isset($_REQUEST['username'])){
    $username=$_REQUEST['username'];
    $sql=$conn->query("SELECT * from user_list where user_name='$username'");
    if($sql->rowCount()>0){
        echo 'false'; 
    } else {
        echo 'true';
       
    }
    
}

?>