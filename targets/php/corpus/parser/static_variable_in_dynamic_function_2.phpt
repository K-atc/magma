<?php

$code = <<<'CODE'
if (1) {
    function test() {
        static $x = 0;
        var_dump(++$x);
    }
}
CODE;
eval($code);
test();
test();

?>