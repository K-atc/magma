<?php
function a() {
    b();
}

function b() {
    c();
}

function c() {
    debug_print_backtrace(0, 1);
    echo "\n";
    debug_print_backtrace(0, 2);
    echo "\n";
    debug_print_backtrace(0, 0);
    echo "\n";
    debug_print_backtrace(0, 4);
}

a();
?>