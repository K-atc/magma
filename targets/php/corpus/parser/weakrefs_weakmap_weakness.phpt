<?php

$map = new WeakMap;

// This is doing to be inserted into the map and immediately removed again
$map[new stdClass] = 1;
var_dump($map);

$obj = new stdClass;
$map[$obj] = 2;
var_dump($map);

unset($obj);
var_dump($map);

echo "\nDestructor in WeakMap value:\n";
$obj = new stdClass;
$map[$obj] = new class {
    public function __destruct() {
        echo "Dtor!\n";
    }
};

echo "Before unset:\n";
unset($obj);
echo "After unset:\n";
var_dump($map);

echo "\nDestroying map with live object:\n";
$obj = new stdClass;
$map[$obj] = 3;
unset($map);
var_dump($obj);

echo "\nObject freed by GC:\n";
$map = new WeakMap;
$obj = new stdClass;
$obj->obj = $obj;
$map[$obj] = 4;
unset($obj);
var_dump($map);
gc_collect_cycles();
var_dump($map);

echo "\nStoring object as own value:\n";
$map = new WeakMap;
$obj = new stdClass;
$map[$obj] = $obj;
unset($obj);
var_dump($map);
unset($map);

echo "\nStoring map in itself:\n";
$map = new WeakMap;
$map[$map] = $map;
var_dump($map);
unset($map);

?>