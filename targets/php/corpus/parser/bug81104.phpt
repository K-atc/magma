<?php
class X {
    public $x;
    public function __construct() { $this->x = [$this]; }
}
gc_disable();
ini_set('memory_limit', '10M');
$y = [];
for ($i = 0; $i < 10000; $i++) {
    $y[] = new X();
}
$y[0]->y = &$y;

?>
===DONE===