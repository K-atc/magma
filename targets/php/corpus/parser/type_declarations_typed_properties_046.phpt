<?php
class Foo {
    public int $bbb;
}

function foo() {
    return new Foo();
}

function bar() {
    return str_repeat("b", 3);
}

for ($i = 0; $i < 5; $i++) {
    try {
        foo()->{bar()} = str_repeat("a", 3);
    } catch (Throwable $e) {
        echo $e->getMessage() . "\n";
    }
}
?>