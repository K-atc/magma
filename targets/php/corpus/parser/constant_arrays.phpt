<?php

define('FOOBAR', [1, 2, 3, ['foo' => 'bar']]);
const FOO_BAR = [1, 2, 3, ['foo' => 'bar']];

$x = FOOBAR;
$x[0] = 7;
var_dump($x, FOOBAR);

$x = FOO_BAR;
$x[0] = 7;
var_dump($x, FOO_BAR);

// ensure references are removed
$x = 7;
$y = [&$x];
define('QUX', $y);
$y[0] = 3;
var_dump($x, $y, QUX);

// ensure objects not allowed in arrays
try {
    define('ELEPHPANT', [new StdClass]);
} catch (TypeError $exception) {
    echo $exception->getMessage() . "\n";
}

// ensure recursion doesn't crash
$recursive = [];
$recursive[0] = &$recursive;

try {
    define('RECURSION', $recursive);
} catch (ValueError $exception) {
    echo $exception->getMessage() . "\n";
}
?>