<?php
$filename = __DIR__ . '/bug79514.doesnotexist';
@include $filename;
// Further include should not increase memory usage.
$mem1 = memory_get_usage();
@include $filename;
$mem2 = memory_get_usage();
var_dump($mem1 == $mem2);
?>