<?php

function &returns_ref($unused) {
    global $foo;
    return $foo;
}

function &returns_ref2() {
    $null = null;
    return returns_ref($null?->null);
}

global $foo;

$foo2 = &returns_ref2();
$foo2 = 'foo';
var_dump($foo);

?>