<?php

class Foo {
    public $bar = 'bar';

    function qux() {
        return 'qux';
    }
}

$null = null;
$foo = new Foo();

var_dump(null?->bar);
var_dump(null?->baz);
var_dump(null?->qux());
var_dump(null?->quux());

var_dump($foo?->bar);
var_dump($foo?->baz);
var_dump($foo?->qux());
try {
    var_dump($foo?->quux());
} catch (Throwable $e) {
    var_dump($e->getMessage());
}

var_dump((new Foo)?->bar);
var_dump((new Foo)?->baz);
var_dump((new Foo)?->qux());
try {
    var_dump((new Foo)?->quux());
} catch (Throwable $e) {
    var_dump($e->getMessage());
}

?>