<?php
class A {
}

class B {
}

$a = new A;
$b = new B;

$f = function (A $a){};

$f($a);
$f->__invoke($a);
call_user_func(array($f,"__invoke"), $a);

try {
    $f($b);
} catch (Error $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
try {
    $f->__invoke($b);
} catch (Error $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
try {
    call_user_func(array($f,"__invoke"), $b);
} catch (Error $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
?>