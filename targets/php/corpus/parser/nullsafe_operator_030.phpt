<?php

class Test {
    public function method($value) {
        return $value;
    }
}

$null = null;
var_dump(empty($null?->method()));
$test = new Test;
var_dump(empty($test?->method(false)));
var_dump(empty($test?->method(42)));

?>