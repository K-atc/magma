<?php

enum Foo {
    case Bar;

    public function __isset($property) {
        return true;
    }
}

?>