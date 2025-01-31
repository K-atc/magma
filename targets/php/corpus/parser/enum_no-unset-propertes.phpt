<?php

enum Foo {
    case Bar;
}

enum IntFoo: int {
    case Bar = 0;
}

$foo = Foo::Bar;
try {
    unset($foo->name);
} catch (Error $e) {
    echo $e->getMessage() . "\n";
}

$intFoo = IntFoo::Bar;
try {
    unset($intFoo->name);
} catch (Error $e) {
    echo $e->getMessage() . "\n";
}
try {
    unset($intFoo->value);
} catch (Error $e) {
    echo $e->getMessage() . "\n";
}

?>