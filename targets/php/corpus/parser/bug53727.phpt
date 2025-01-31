<?php
interface MyInterface {
    const TEST_CONSTANT = true;
}

class ParentClass implements MyInterface { }

class ChildClass extends ParentClass { }

echo (is_subclass_of('ChildClass', 'MyInterface') ? 'true' : 'false') . "\n";
echo (defined('ChildClass::TEST_CONSTANT') ? 'true' : 'false') . "\n";

echo (is_subclass_of('ParentClass', 'MyInterface') ? 'true' : 'false') . "\n";
echo (defined('ParentClass::TEST_CONSTANT') ? 'true' : 'false') . "\n";
?>