<?php

enum Foo {
    case Bar;
}

debug_zval_dump(Foo::Bar);

$foo = Foo::Bar;
debug_zval_dump($foo);

$bar = unserialize('E:7:"Foo:Bar";');
debug_zval_dump($foo);

unset($bar);
debug_zval_dump($foo);

unset($foo);
debug_zval_dump(Foo::Bar);

?>