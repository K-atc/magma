<?php

function takes_ref(&$foo) {
    $foo = 'foo';
}

function &returns_ref($ref) {
    global $foo;
    return $foo;
}

global $foo;

$null = null;
takes_ref(returns_ref($null?->null()));
var_dump($foo);

?>