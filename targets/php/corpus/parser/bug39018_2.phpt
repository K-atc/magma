<?php

error_reporting(E_ALL);

$foo = 'test';
$x = @$foo[6];

var_dump(@($foo[100] . $foo[130]));

?>