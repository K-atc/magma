<?php
class Foo {
    function test1() {
        $method = ['Foo', 'bar'];
        $method();
    }
    function test2() {
        $method = 'Foo::bar';
        $method();
    }
    function __call($name, $args) {}
}
$x = new Foo;
try {
    $x->test1();
} catch (Error $e) {
    echo $e->getMessage(), "\n";
}
try {
    $x->test2();
} catch (Error $e) {
    echo $e->getMessage(), "\n";
}
?>