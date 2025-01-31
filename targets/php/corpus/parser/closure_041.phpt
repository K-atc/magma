<?php

/* It's impossible to preserve the previous scope when doing so would break
 * the invariants that, for non-static closures, having a scope is equivalent
 * to having a bound instance. */

$staticUnscoped = static function () {
    echo "scoped to A: "; var_dump(isset(A::$priv));
    echo "bound: ", isset($this)?get_class($this):"no";
};

$nonstaticUnscoped = function () {
    echo "scoped to A: "; var_dump(isset(A::$priv));
    echo "bound: ", isset($this)?get_class($this):"no";
};

class A {
    private static $priv = 7;
    function getClosure() {
        return function () {
            echo "scoped to A: "; var_dump(isset(A::$priv));
            echo "bound: ", isset($this)?get_class($this):"no";
        };
    }
    function getStaticClosure() {
        return static function () {
            echo "scoped to A: "; var_dump(isset(A::$priv));
            echo "bound: ", isset($this)?get_class($this):"no";
        };
    }
}
class B extends A {}

$a = new A();
$staticScoped = $a->getStaticClosure();
$nonstaticScoped = $a->getClosure();

echo "Before binding", "\n";
$staticUnscoped(); echo "\n";
$nonstaticUnscoped(); echo "\n";
$staticScoped(); echo "\n";
$nonstaticScoped(); echo "\n";

echo "After binding, no instance", "\n";
$d = $staticUnscoped->bindTo(null); $d(); echo "\n";
$d = $nonstaticUnscoped->bindTo(null); $d(); echo "\n";
$d = $staticScoped->bindTo(null); $d(); echo "\n";
$d = $nonstaticScoped->bindTo(null); var_dump($d); echo "\n";

echo "After binding, with same-class instance for the bound ones", "\n";
$d = $staticUnscoped->bindTo(new A);
$d = $nonstaticUnscoped->bindTo(new A); $d(); echo " (should be scoped to dummy class)\n";
$d = $staticScoped->bindTo(new A);
$d = $nonstaticScoped->bindTo(new A); $d(); echo "\n";

echo "After binding, with different instance for the bound ones", "\n";
$d = $nonstaticUnscoped->bindTo(new B); $d(); echo " (should be scoped to dummy class)\n";
$d = $nonstaticScoped->bindTo(new B); $d(); echo "\n";

echo "Done.\n";
?>