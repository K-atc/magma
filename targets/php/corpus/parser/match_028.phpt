<?php

// opcache can't be certain Test::usesRef is actually this method
if (!class_exists('Test')) {
    class Test {
        public static function usesRef(&$x) {
            $x = 'modified';
        }
        public static function usesValue($x) {
            echo "usesValue $x\n";
        }
    }
}

function main(int $i): int {
    Test::usesValue(match(true) { true => $i });
    Test::usesValue(match($i) { 42 => $i });
    var_dump($i);
    Test::usesRef(match(true) { true => $i });
    var_dump($i);
}

try {
    main(42);
} catch (Error $e) {
    printf("Caught %s\n", $e->getMessage());
}

?>