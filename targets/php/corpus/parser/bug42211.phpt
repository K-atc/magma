<?php
class A {
    function foo() {
        var_dump(property_exists('B', 'publicBar'));
        var_dump(property_exists('B', 'protectedBar'));
        var_dump(property_exists('B', 'privateBar'));
    }
}

class B extends A {
    static public $publicBar = "ok";
    static protected $protectedBar = "ok";
    static private $privateBar = "fail";
}

$a = new A();
$a->foo();
$b = new B();
$b->foo();
?>