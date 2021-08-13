<?php

for($i=1;$i<50;$i++){
    if($i % 2 == 0){
        $evenArray[]=$i;
    }else{
        $oddArray[]=$i;
    }
}
echo "The Odd  ";
print_r($oddArray);
echo "<br>";
echo "<br>";
echo "The Even  ";
print_r($evenArray);
?>