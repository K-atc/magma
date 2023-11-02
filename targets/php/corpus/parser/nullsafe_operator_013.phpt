<?php

function dump_error(callable $callable) {
    try {
        var_dump($callable());
    } catch (Throwable $e) {
        var_dump($e->getMessage());
    }
}

function foo() {}

$foo = null;
dump_error(fn() => strlen($foo?->foo()));
dump_error(fn() => is_null($foo?->foo()));
dump_error(fn() => is_bool($foo?->foo()));
dump_error(fn() => is_int($foo?->foo()));
dump_error(fn() => is_scalar($foo?->foo()));
dump_error(fn() => boolval($foo?->foo()));
dump_error(fn() => defined($foo?->foo()));
dump_error(fn() => chr($foo?->foo()));
dump_error(fn() => ord($foo?->foo()));
dump_error(fn() => call_user_func_array($foo?->foo(), []));
dump_error(fn() => call_user_func_array('foo', $foo?->foo()));
dump_error(fn() => get_class($foo?->foo()));
dump_error(fn() => get_called_class($foo?->foo()));
dump_error(fn() => gettype($foo?->foo()));
dump_error(fn() => func_num_args($foo?->foo()));
dump_error(fn() => func_get_args($foo?->foo()));
dump_error(fn() => array_slice($foo?->foo(), 0));
dump_error(fn() => array_slice(['foo'], $foo?->foo()));
dump_error(fn() => array_slice(['foo'], 0, $foo?->foo()));
dump_error(fn() => array_key_exists($foo?->foo(), []));
dump_error(fn() => array_key_exists('foo', $foo?->foo()));

?>