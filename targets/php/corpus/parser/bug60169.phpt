<?php
error_reporting(0);
$arr  = array("test");
list($a,$b) = is_array($arr)? $arr : $arr;
list($c,$d) = is_array($arr)?: NULL;
echo "ok\n";
?>