<?php

trait TraitA
{
    public static function as(){ echo __METHOD__, PHP_EOL; }
}

class Foo
{
    use TraitA  {
        as as try;
    }
}

Foo::try();

echo PHP_EOL, "Done", PHP_EOL;
?>