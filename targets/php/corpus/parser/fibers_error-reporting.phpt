<?php

error_reporting(E_ALL & ~E_USER_NOTICE);

$fiber = new Fiber(function (): void {
    trigger_error("Notice A", E_USER_NOTICE); // Should be silenced.
    Fiber::suspend();
    trigger_error("Warning A", E_USER_WARNING);
});

$fiber->start();

trigger_error("Notice B", E_USER_NOTICE); // Should be silenced.

$fiber->resume();

trigger_error("Warning B", E_USER_WARNING);

?>