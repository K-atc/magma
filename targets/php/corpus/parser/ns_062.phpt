<?php
namespace Foo;
use \stdClass;
use \stdClass as A;
echo get_class(new stdClass)."\n";
echo get_class(new A)."\n";
?>