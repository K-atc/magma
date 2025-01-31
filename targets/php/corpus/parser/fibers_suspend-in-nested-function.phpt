<?php

function suspend(): int
{
    return Fiber::suspend(1);
}

$fiber = new Fiber(function (): int {
    $value = suspend();
    return Fiber::suspend($value);
});

var_dump($fiber->start());
var_dump($fiber->resume(2));
var_dump($fiber->resume(3));
var_dump($fiber->getReturn());

echo "done\n";

?>