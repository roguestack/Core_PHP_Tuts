<?php
$num=array('3','6','4','8','2');
// print_r (count($num));

for($i=0;$i<count($num);$i++){
    for($j=0;$j<count($num)-1;$j++){
        if($num[$j]>$num[$j+1]){
            $k=$num[$j+1];
            $num[$j+1]=$num[$j];
            $num[$j]=$k;
        }
    }
}
echo "<br>";
print_r($num);

?>