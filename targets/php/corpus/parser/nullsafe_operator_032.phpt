<?php

class Test {
    public $foo = 42;

    public function method() {
        var_dump($this?->foo);
        var_dump($this?->bar());
    }

    public function bar() {
        return 24;
    }
}

$test = new Test;
$test->method();

?>