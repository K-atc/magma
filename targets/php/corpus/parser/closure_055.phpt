<?php

class A {
    static function foo() {
        $f = static function() {
            return self::class;
        };
        return $f();
    }
}

class B extends A {}

var_dump(B::foo());
?>