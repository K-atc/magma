<?php

echo 'Bitwise ops:' . \PHP_EOL;
// 8 Warnings generated in total
$var = ~1.5;
var_dump($var);
$var = 1.5|3;
var_dump($var);
$var = 1.5&3;
var_dump($var);
$var = 1.5^3;
var_dump($var);
$var = 1.5 << 3;
var_dump($var);
$var = 1.5 >> 3;
var_dump($var);
$var = 3 << 1.5;
var_dump($var);
$var = 3 >> 1.5;
var_dump($var);

echo 'Modulo:' . \PHP_EOL;
// 2 warnings in total
$var = 6.5 % 2;
var_dump($var);
$var = 9 % 2.5;
var_dump($var);

echo 'Offset access:' . \PHP_EOL;
echo 'Arrays:' . \PHP_EOL;
// 2 warnings in total
$array = ['a', 'b', 'c'];
var_dump($array[1.5]);
$array[2.5] = 'z';
var_dump($array);

echo 'Strings:' . \PHP_EOL;
// 2 warnings in total
$string = 'php';
var_dump($string[1.5]);
$string[2.5] = 'z';
var_dump($string);

echo 'Function calls:' . \PHP_EOL;
function foo(int $a) {
    return $a;
}
var_dump(foo(1.5));

var_dump(chr(60.5));

echo 'Function returns:' . \PHP_EOL;
function bar(): int {
    return 3.5;
}
var_dump(bar());

echo 'Typed property assignment:' . \PHP_EOL;
class Test {
    public int $a;
}

$instance = new Test();
$instance->a = 1.5;
var_dump($instance->a);

?>