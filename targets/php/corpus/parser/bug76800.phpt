<?php
$arr = [1 => 1, 3 => 3];           // [1 => 1, 2 => 3] will print both keys
foreach($arr as $key => &$val) {   // without & will print both keys
    echo "See key {$key}\n";
    $arr[0] = 0;                   // without this line will print both keys
    unset($arr[0]);
}
?>