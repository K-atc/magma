<?php
trait T1
{
    protected function aa() { echo 123; }
}

trait T2
{
    use T1 {
        aa as public;
    }
}

class A
{
    use T1;
}

class B extends A
{
    use T2;
}

$b = new B();
$b->aa();
?>