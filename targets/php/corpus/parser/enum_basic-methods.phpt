<?php

enum Foo {
    case Bar;
    case Baz;

    public function dump() {
        var_dump($this);
    }
}

Foo::Bar->dump();
Foo::Baz->dump();

?>