<?php

function findCount($arr, $ent){
	$count = 0;
	foreach($arr as $x) {
        if ($x == $ent)
            $count += 1;
    }
    return $count;
}


$arr = array(1,2,3,4,1,2,3,6,8,4,2,3,5,4,2,1,4);
$ent = 4;

echo findCount($arr,$ent);
