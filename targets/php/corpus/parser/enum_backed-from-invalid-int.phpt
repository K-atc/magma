<?php

enum Foo: int {
    case Bar = 0;
    case Baz = 1;
}

try {
    var_dump(Foo::from(2));
} catch (Error $e) {
    echo $e->getMessage() . "\n";
}

?>