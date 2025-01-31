<?php

function try_and_dump($fn) {
    try {
        var_dump($fn());
    } catch (\Error $e) {
        echo $e->getMessage() . "\n";
    }
}

class Foo {
    public function bar() {
        echo "bar\n";
    }
}

$foo = new Foo();
$null = null;

try_and_dump(fn() => $null?->null() + $null?->null());
try_and_dump(fn() => $foo?->bar() + $null?->null());
try_and_dump(fn() => $null?->null() + $foo?->bar());
try_and_dump(fn() => $foo->bar() + $null?->null());
try_and_dump(fn() => $null?->null() + $foo->bar());
try_and_dump(fn() => $null?->null() + $null->null());
try_and_dump(fn() => $null->null() + $null?->null());
try_and_dump(fn() => ($foo?->bar() + $foo?->bar())?->baz());

?>